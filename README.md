# Snippets Call/Text By Proxy
This example masks the phone numbers for pairs of callers through proxy numbers hosted by SignalWire.
## About Call/Text By Proxy
Common use cases include services, such as ride-sharing where both the passengers and the drivers want their phone numbers masked from the other party.
## Getting Started
This script is designed to be used on any standard shared hosting infrastructure using PHP, such as 1&1 IONOS.
----
## Running Call/Text By Proxy - How It Works
## Methods and Endpoints

```
Endpoint: /lookup-session
Methods: GET OR POST
When this is called, it will lookup an active proxy session and create a back to back phone call that is proxied, or a proxied text message.  LEG A <-> SignalWire PROXY <-> LEG B
```

## Setup Your Environment File

1. Copy from example.env and fill in your values
2. Save new file called .env

Your file should look something like this
```
## This is the full name of your SignalWire Space. e.g.: example.signalwire.com
SIGNALWIRE_SPACE_URL=
# Your Project ID - you can find it on the `API` page in your Dashboard.
SIGNALWIRE_PROJECT=
# Your API token - you can generate one on the `API` page in your Dashboard
SIGNALWIRE_TOKEN=
# The proxy 1 phone number you'll be using in e.164 format. Must include the `+1` , e.g., +15551234567
SIGNALWIRE_NUMBER_1=+15556611212
# The proxy 2 phone number you'll be using in e.164 format. Must include the `+1` , e.g., +15551234568
SIGNALWIRE_NUMBER_2=+15556611213
```

## Modify Your Proxy Session File
1. Edit proxy_sessions.json
```javascript
[
  {
    "Session_Id": "Demo123",
    "Participant_A_Number": "+15551237654",
    "Participant_B_Number": "+15553883000",
    "Proxy_Number": "+15556611212"
  },
  {
    "Session_Id": "Demo234",
    "Participant_A_Number": "+15555181212",
    "Participant_B_Number": "+12347896543",
    "Proxy_Number": "+15556611213"
  }
]

```

## Dependencies
The composer.json file is included with this project.  It requires both signalwire/signalwire and vlucas/dotenv.  Copy all the files to your Web host and do a composer update.

Also, note that because PHP on shared hosting providers does not support threading, the project calls out to the shell to execute a PHP script asynchronously.  You should make sure to configure the PHP command line interface appropriately.  For example, on 1&1 IONOS, /usr/bin/php does not utilize PHP 7 by default.

----

# More Documentation
You can find more documentation on LaML, Relay, and all Signalwire APIs at:
- [SignalWire PHP SDK](https://github.com/signalwire/signalwire-php)
- [SignalWire API Docs](https://docs.signalwire.com)
- [SignalWire Github](https://gituhb.com/signalwire)
