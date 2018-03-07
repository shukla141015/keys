<template>
    <div>

        <div v-for="wallet in wallets"
             class="wallet flex font-mono text-sm pl-4 mb-4"
             :class="{
                loading: ! wallet.loaded,
                empty:   wallet.loaded && ! wallet.balance,
                used:    wallet.loaded && wallet.transactionCount,
             }"
        >

            <span>
                Public key:&nbsp; <a :href="'https://blockchain.info/address/'+wallet.publicKey" rel="nofollow" target="_blank">{{ wallet.publicKey }}</a>
            </span>
            <span>
                Private key: {{ wallet.privateKey }}
            </span>
            <span>
                <strong class="w-16">Balance:</strong> {{ wallet.balance }} btc ({{ wallet.transactionCount }} tx)
            </span>

        </div>
    </div>
</template>

<script>
    export default {

        props: [
            'page'
        ],

        data: () => ({
            wallets: [],
        }),

        mounted() {
            // Calculate the first seed for this page.
            let bigInt = bigi(this.page).subtract(bigi.ONE).multiply(bigi('128')).add(bigi.ONE);

            let keyPairs = this.generateKeyPairs(bigInt, 128);

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


            let addresses = this.wallets.map(w => w.publicKey).join('|');

            // http://keys.pk/api/v1/mock-balance?active=
            // https://blockchain.info/balance?cors=true&active=
            axios.get('http://keys.pk/api/v1/mock-balance?active=' + addresses).then(response => {
                this.wallets.forEach(wallet => {
                    this.sleep(Math.random() * 10 * 300).then(() => {
                        let data = response.data[wallet.publicKey];

                        wallet.balance          = data.final_balance /  100000000;
                        wallet.transactionCount = data.n_tx;
                        wallet.totalReceived    = data.total_received / 100000000;
                        wallet.loaded           = true;
                    });
                });
            });
        },

        methods: {
            generateKeyPairs: function (bigInt, amount) {
                let keyPairs = [];

                for (let i = 0; i < amount; i++) {
                    keyPairs.push(
                        new bitcoin.ECPair(bigInt, null, {compressed: false})
                    );

                    bigInt = bigInt.add(bigi.ONE);
                }

                return keyPairs;
            },

            sleep: function (ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            },
        }

    }
</script>