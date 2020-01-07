# NetSuite Endpoints for Cockpit CMS

## Installation
Install Cockpit CMS addon by extracting to the addons folder (/addons/NetSuite)

### Install Dependencies

```
$ cd /addons/NetSuite
$ composer install
```

### Add NetSuite API Key to Config

```
netsuite:
    account: YOUR_ACCOUNT_ID
    consumerKey: YOUR_CONSUMER_KEY
    consumerSecret: YOUR_CONSUMER_SECRET
    tokenId: YOUR_TOKEN_ID
    tokenSecret: YOUR_TOKEN_SECRET
```