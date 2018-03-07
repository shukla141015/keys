<template>
    <div>

        <div class="mb-4" v-if="this.lastSeenUnix">
            Page last checked on: {{ new Date(this.lastSeenUnix * 1000).toISOString().slice(0, -5).replace('T', ' - ') }}
        </div>
        <div class="mb-4" v-else>
            This page has never been checked before
        </div>

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

        props: ['page', 'lastSeen', 'wasEmpty'],

        data: () => ({
            wallets: [],
            lastSeenUnix: false
        }),

        mounted() {
            this.lastSeenUnix = this.lastSeen;

            let keyPairs = this.generateKeyPairs(128);

            keyPairs.forEach(keyPair => {
                this.wallets.push({
                    publicKey: keyPair.getAddress(),
                    privateKey: keyPair.toWIF(),
                    loaded:           !! this.wasEmpty,
                    balance:          this.wasEmpty ? 0 : '?',
                    transactionCount: this.wasEmpty ? 0 : '?',
                    totalReceived:    this.wasEmpty ? 0 : '?',
                })
            });

            if (! this.wasEmpty) {
                this.loadBalances();
            }
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

                            if (this.wallets.every(w => w.loaded)) {
                                this.putPageStatus();
                            }
                        });
                    });
                });
            },

            putPageStatus: function () {
                let isEmptyPage = this.wallets.every(w => w.transactionCount === 0);

                axios.put('/api/v1/btc/page', {
                    'page_number': this.page,
                    'empty': isEmptyPage,
                });

                this.lastSeenUnix = new Date() / 1000;
            },
            
            sleepRandom: function (maxMs) {
                return new Promise(resolve => setTimeout(resolve, Math.random() * maxMs));
            },
        }

    }
</script>