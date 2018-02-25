<template>
    <div>
        <div class="font-mono text-sm mb-4">
            Seed: {{ this.seed }} (<a :href="'/?seed='+this.seed" rel="nofollow">permalink</a>)
        </div>

        <div v-for="wallet in wallets"
             class="wallet flex flex-col font-mono text-sm pl-4 mb-4"
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
            'initialSeed'
        ],

        data: () => ({
            seed: null,
            wallets: [],
        }),

        mounted() {
            this.seed = this.initialSeed || randomBytes.sync(32).toString('hex');

            let keyPairs = this.generateKeyPairs(12);

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

            axios.get('https://blockchain.info/balance?cors=true&active=' + addresses).then(response => {
                this.wallets.forEach(wallet => {
                    this.sleep(Math.random() * 10 * 200).then(() => {
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
            generateKeyPairs: function (amount) {
                let keyPairs = [];

                for (let i = 0; i < amount; i++) {
                    let buffer = Buffer.from(
                        this.seed + i.toString(16)
                    );
                    
                    let hash = bitcoin.crypto.sha256(buffer);

                    let bigInt = bigi.fromBuffer(hash);

                    keyPairs.push(
                        new bitcoin.ECPair(bigInt)
                    );
                }

                return keyPairs;
            },

            sleep: function (ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            }
        }

    }
</script>