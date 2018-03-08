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

            <span class="mr-4">
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
        }),

        mounted() {
            let keyPairs = this.generateKeyPairs(128);

            keyPairs.forEach(keyPair => {
                this.wallets.push({
                    publicKey: keyPair.getAddress(),
                    privateKey: keyPair.toWIF(),
                    loaded:           false,
                    balance:          '?',
                    transactionCount: '?',
                    totalReceived:    '?',
                })
            });

            this.loadBalances();
        },

        methods: {
            generateKeyPairs: function (amount) {
                // Calculate the first seed for this page.
                let bigInt = bigi(this.page).subtract(bigi.ONE).multiply(bigi(''+amount)).add(bigi.ONE);

                let keyPairs = [];

                for (let i = 0; i < amount; i++) {
                    keyPairs.push(
                        new bitcoin.ECPair(bigInt, null, {compressed: false})
                    );

                    bigInt = bigInt.add(bigi.ONE);
                }

                return keyPairs;
            },

            loadBalances: function () {
                let addresses = this.wallets.map(w => w.publicKey).join('|');

                // http://keys.pk/api/v1/mock-balance?active=
                // https://blockchain.info/balance?cors=true&active=
                axios.get('http://keys.pk/api/v1/mock-balance?active='+addresses).then(response => {
                    this.wallets.forEach(wallet => {
                        this.sleepRandom(3000).then(() => {
                            let data = response.data[wallet.publicKey];

                            wallet.balance          = data.final_balance /  100000000;
                            wallet.transactionCount = data.n_tx;
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