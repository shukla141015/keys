// const apiBaseUrl = 'http://keys.pk/api/v1/eth/balance-empty?address=';
const apiBaseUrl = 'https://api.etherscan.io/api?module=account&action=balancemulti&apikey=F92Z14GE2DTF6PBBYY1YPHPJ438PT3P2VI&address=';

const apiCallDelayMs = 750;

//--------

const addresses = keys.map(w => w.publicKey);

// The Etherscan api will only do 20 addresses at once.
const chunkSize = 20;

let apiCallsMade = 1;

for (let i = 0, j = addresses.length; i < j; i += chunkSize) {
    let keysChunk = addresses.slice(i, i + chunkSize);

    // The Etherscan api allows 5 calls per second, if you
    // exceed that you receive a 403 error.
    sleepExactly(apiCallDelayMs * apiCallsMade).then(() => {
        loadBalanceForKeys(keysChunk);
    });

    apiCallsMade++;
}


function loadBalanceForKeys(keys) {
    let addresses = keys.join(',');

    axios.get(apiBaseUrl + addresses).then(response => {
        response.data.result.forEach(account => {
            addValuesToWallet(account.account, account.balance);
        });
    });
}


function addValuesToWallet(publicKey, balance) {
    const el = document.getElementById(publicKey);

    const balanceEl = el.querySelector('.wallet-balance');

    balanceEl.innerHTML = (balance / 1000000000000000000).toString().substr(0, 5) + ' eth';

    el.classList.remove('loading');

    balance > 0
        ? el.classList.add('filled')
        : el.classList.add('empty');
}

function sleepExactly(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
