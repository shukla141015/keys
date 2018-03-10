<template>
    <div>

        <div v-for="wallet in wallets"
             class="wallet flex font-mono text-sm pl-2"
             :class="{
                loading: ! wallet.loaded,
                empty:   wallet.loaded && ! wallet.balance,
                used:    wallet.loaded && wallet.transactionCount,
                filled:  wallet.loaded && wallet.balance,
             }"
        >

            <span class="mr-4 inline-block" :style="txStyle">
                <strong>{{ wallet.balance }} btc</strong> ({{ wallet.transactionCount }} tx)
            </span>
            <span class="mr-4">
                {{ wallet.privateKey }}
            </span>
            <span>
                <a :href="'https://blockchain.info/address/'+wallet.publicKey" rel="nofollow" target="_blank">{{ wallet.publicKey }}</a>
            </span>

        </div>
    </div>
</template>

<script>
    export default {

        props: ['page'],

        data: () => ({
            wallets: [],
            isOnFirstPage: false,
            isOnLastPage: false,
            txStyle: {minWidth: ''},
        }),

        mounted() {
            this.isOnFirstPage = this.page === '1';
            this.isOnLastPage  = this.page === '904625697166532776746648320380374280100293470930272690489102837043110636675';

            // The first, third and last page are the only ones that
            // have double digit transaction counts.
            this.txStyle.minWidth = this.isOnFirstPage ? '108px' : (this.isOnLastPage || this.page === '3' ? '100px' : '');

            let keyPairs = this.generateKeyPairs(128);

            keyPairs.forEach(keyPair => {
                this.wallets.push({
                    publicKey: keyPair.getAddress(),
                    privateKey: keyPair.toWIF(),
                    loaded: false,
                    balance: '?',
                    transactionCount: '?',
                    totalReceived: '?',
                })
            });

            this.loadBalances();
        },

        methods: {
            generateKeyPairs: function (amount) {
                // Calculate the first seed for this page.
                let bigInt = bigi(this.page).subtract(bigi.ONE).multiply(bigi(''+amount));

                let keyPairs = [];

                for (let i = 0; i < amount; i++) {
                    bigInt = bigInt.add(bigi.ONE);

                    keyPairs.push(
                        new bitcoin.ECPair(bigInt, null, {compressed: false})
                    );

                    if (this.isOnLastPage && bigInt.toString() === '115792089237316195423570985008687907852837564279074904382605163141518161494336') {
                        break;
                    }
                }

                return keyPairs;
            },

            loadBalances: function () {
                let addresses;

                // Checking the balance of the first or last wallet on blockchain.info returns an error.
                if (this.isOnFirstPage) {
                    addresses = this.wallets.slice(1).map(w => w.publicKey).join('|');

                    let firstWallet = this.wallets.find(w => w.publicKey === '1EHNa6Q4Jz2uvNExL497mE43ikXhwF6kZm');

                    firstWallet.balance = 0;
                    firstWallet.transactionCount = '99+';
                    firstWallet.totalReceived = 4.86537461;
                    firstWallet.loaded = true;
                } else if (this.isOnLastPage) {
                    addresses = this.wallets.slice(0, -1).map(w => w.publicKey).join('|');

                    let lastWallet = this.wallets.find(w => w.publicKey === '1JPbzbsAx1HyaDQoLMapWGoqf9pD5uha5m');

                    lastWallet.balance = 0;
                    lastWallet.transactionCount = 11;
                    lastWallet.totalReceived = 2.32500983;
                    lastWallet.loaded = true;
                } else {
                    addresses = this.wallets.map(w => w.publicKey).join('|');
                }

                // http://keys.pk/api/v1/mock-balance?active=
                // https://blockchain.info/balance?cors=true&active=
                axios.get('https://blockchain.info/balance?cors=true&active='+addresses).then(response => {
                    this.wallets.forEach(wallet => {
                        this.sleepRandom(3000).then(() => {
                            let data = response.data[wallet.publicKey];

                            if (data === undefined) {
                                return;
                            }

                            wallet.balance          = data.final_balance / 100000000;
                            wallet.transactionCount = data.n_tx ? (data.n_tx > 99 ? '99+' : data.n_tx) : 0;
                            wallet.totalReceived    = data.total_received / 100000000;
                            wallet.loaded           = true;
                        });
                    });
                });
            },

            sleepRandom: function (maxMs) {
                return new Promise(resolve => setTimeout(resolve, Math.random() * maxMs));
            },
        }

    }
</script>
