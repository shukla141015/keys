<template>
    <div>

        <div v-for="wallet in wallets"
             class="wallet flex flex-col lg:flex-row font-mono text-sm md:text-sm pl-2 lg:py-0 py-2"
             :class="{
                loading: wallet.loaded !== 2,
                empty:   wallet.loaded === 2 && ! wallet.balance,
                used:    wallet.loaded === 2 && wallet.transactionCount,
                filled:  wallet.loaded === 2 && wallet.balance,
             }"
        >

            <span class="mr-4 inline-block" :style="txStyle">
                <strong>{{ wallet.balance }} btc</strong>
                <span v-html="presentTx(wallet.transactionCount)"></span>
            </span>


            <span class="lg:mr-4 text-xs sm:text-sm break-words">
                {{ wallet.wif }}
            </span>
            <div class="lg:block flex">
                <span class="mr-8 lg:mr-4">
                    <a :href="'https://blockchain.info/address/'+wallet.publicKey" rel="nofollow" target="_blank">
                        <span class="hidden xl:inline-block" v-html="rpad(wallet.publicKey, 34)"></span>
                        <span class="xl:hidden inline-block">public key</span>
                    </a>
                </span>
                <span>
                    <a :href="'https://blockchain.info/address/'+wallet.compressedPublicKey" rel="nofollow" target="_blank">
                        <span class="hidden xl:inline-block">{{ wallet.compressedPublicKey }}</span>
                        <span class="xl:hidden inline-block">compressed public key</span>
                    </a>
                </span>
            </div>

        </div>
    </div>
</template>

<script>
    export default {

        props: ['keys', 'isOnFirstPage', 'isOnLastPage'],

        data: () => ({
            wallets: [],
            txStyle: {minWidth: ''},
        }),

        mounted() {
            // The first, third and last page are the only ones that
            // have double digit transaction counts.
            this.txStyle.minWidth = this.isOnFirstPage ? '108px' : (this.isOnLastPage || this.page === '3' ? '100px' : '');

            this.keys.forEach(keySet => {
                this.wallets.push({
                    publicKey: keySet.pub,
                    compressedPublicKey: keySet.cpub,
                    wif: keySet.wif,
                    loaded: 0,
                    balance: 0,
                    transactionCount: false,
                    totalReceived: 0,
                })
            });

            this.loadUncompressedBalances();

            this.loadCompressedBalances();
        },

        methods: {
            loadUncompressedBalances: function () {
                let addresses;

                // Checking the balance of the first or last wallet on blockchain.info returns an error.
                if (this.isOnFirstPage) {
                    addresses = this.wallets.slice(1).map(w => w.publicKey).join('|');

                    let firstWallet = this.wallets.find(w => w.publicKey === '1EHNa6Q4Jz2uvNExL497mE43ikXhwF6kZm');

                    firstWallet.balance += 0;
                    firstWallet.transactionCount += 1201;
                    firstWallet.totalReceived += 4.86537461;
                    firstWallet.loaded += 1;
                } else if (this.isOnLastPage) {
                    addresses = this.wallets.slice(0, -1).map(w => w.publicKey).join('|');

                    let lastWallet = this.wallets.find(w => w.publicKey === '1JPbzbsAx1HyaDQoLMapWGoqf9pD5uha5m');

                    lastWallet.balance += 0;
                    lastWallet.transactionCount += 11;
                    lastWallet.totalReceived += 2.32500983;
                    lastWallet.loaded += 1;
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

                            wallet.balance          += data.final_balance / 100000000;
                            wallet.transactionCount += data.n_tx;
                            wallet.totalReceived    += data.total_received / 100000000;
                            wallet.loaded           += 1;
                        });
                    });
                });
            },

            loadCompressedBalances: function () {
                let addresses;

                if (this.isOnFirstPage) {
                    addresses = this.wallets.slice(1).map(w => w.compressedPublicKey).join('|');

                    let firstWallet = this.wallets.find(w => w.compressedPublicKey === '1BgGZ9tcN4rm9KBzDn7KprQz87SZ26SAMH');

                    firstWallet.balance += 0;
                    firstWallet.transactionCount += 24;
                    firstWallet.totalReceived += 0.14592834;
                    firstWallet.loaded += 1;
                } else {
                    addresses = this.wallets.map(w => w.compressedPublicKey).join('|');
                }


                // http://keys.pk/api/v1/mock-balance?active=
                // https://blockchain.info/balance?cors=true&active=
                axios.get('https://blockchain.info/balance?cors=true&active='+addresses).then(response => {
                    this.wallets.forEach(wallet => {
                        this.sleepRandom(3000).then(() => {
                            let data = response.data[wallet.compressedPublicKey];

                            if (data === undefined) {
                                return;
                            }

                            wallet.balance          += data.final_balance / 100000000;
                            wallet.transactionCount += data.n_tx;
                            wallet.totalReceived    += data.total_received / 100000000;
                            wallet.loaded           += 1;
                        });
                    });
                });
            },

            sleepRandom: function (maxMs) {
                return new Promise(resolve => setTimeout(resolve, Math.random() * maxMs));
            },

            rpad: function (value, length) {
                let extraSpaces = 0;

                while (value.length + extraSpaces < length) {
                    extraSpaces++;
                }

                return value + '&nbsp;'.repeat(extraSpaces);
            },

            presentTx: function (value) {
                let text = value === false ? '?' : (value > 99 ? '99+' : value);

                let extraSpaces = 0;

                let longestTxString = this.longestTxString;

                while (text.length + extraSpaces < longestTxString) {
                    extraSpaces++;
                }

                return '('+text+' tx)' + '&nbsp;'.repeat(extraSpaces);
            },
        },


        computed: {
            longestTxString: function () {

                return Math.max.apply(Math, this.wallets.map(function (wallet) {
                    if (wallet.transactionCount === false) {
                        return 1;
                    }

                    let length = wallet.transactionCount.toString().length;

                    return length > 3 ? 3 : length;
                }));

            },
        },

    }
</script>
