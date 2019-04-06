# ultimatetwitter

```
composer require 39ff/ultimatetwitter
```


## get public endpoint contents without api key
```php
use koulab\UltimateTwitter\Client;
$to = new Client();
$response = $to->get('https://api.twitter.com/1.1/users/show.json?screen_name=twitter');
print_r($response);

```


```json
{"id":783214,"id_str":"783214","name":"Twitter","screen_name":"Twitter","location":"Everywhere","profile_location":null,"description":"What\u2019s happening?!","url":"https:\/\/t.co\/TAXQpsHa5X","entities":{"url":{"urls":[{"url":"https:\/\/t.co\/TAXQpsHa5X","expanded_url":"https:\/\/about.twitter.com\/","display_url":"about.twitter.com","indices":[0,23]}]},"description":{"urls":[]}},"protected":false,"followers_count":56055026,"fast_followers_count":7769,"normal_followers_count":56047257,"friends_count":139,"listed_count":91391,"created_at":"Tue Feb 20 14:35:54 +0000 2007","favourites_count":5839,"utc_offset":null,"time_zone":null,"geo_enabled":true,"verified":true,"statuses_count":9780,"media_count":1918,"lang":"en","status":{"created_at":"Sat Apr 06 14:52:34 +0000 2019","id":1114541412672995329,"id_str":"1114541412672995329","text":"@Tim535353 @helenium @marciadorsey We know a bird who can hook you up...","truncated":false,"entities":{"hashtags":[],"symbols":[],"user_mentions":[{"screen_name":"Tim535353","name":"Tim Dorsey","id":59,"id_str":"59","indices":[0,10]},{"screen_name":"helenium","name":"Helen Lawrence","id":7563452,"id_str":"7563452","indices":[11,20]},{"screen_name":"marciadorsey","name":"Marcia Dorsey\ud83c\udf3b","id":76,"id_str":"76","indices":[21,34]}],"urls":[]},"source":"\u003ca href=\"http:\/\/twitter.com\/download\/iphone\" rel=\"nofollow\"\u003eTwitter for iPhone\u003c\/a\u003e","in_reply_to_status_id":1114523043089584142,"in_reply_to_status_id_str":"1114523043089584142","in_reply_to_user_id":59,"in_reply_to_user_id_str":"59","in_reply_to_screen_name":"Tim535353","geo":null,"coordinates":null,"place":null,"contributors":null,"is_quote_status":false,"retweet_count":1,"favorite_count":10,"favorited":false,"retweeted":false,"lang":"en","supplemental_language":null},"contributors_enabled":false,"is_translator":false,"is_translation_enabled":false,"profile_background_color":"ACDED6","profile_background_image_url":"http:\/\/abs.twimg.com\/images\/themes\/theme18\/bg.gif","profile_background_image_url_https":"https:\/\/abs.twimg.com\/images\/themes\/theme18\/bg.gif","profile_background_tile":true,"profile_image_url":"http:\/\/pbs.twimg.com\/profile_images\/1111729635610382336\/_65QFl7B_normal.png","profile_image_url_https":"https:\/\/pbs.twimg.com\/profile_images\/1111729635610382336\/_65QFl7B_normal.png","profile_banner_url":"https:\/\/pbs.twimg.com\/profile_banners\/783214\/1554147948","profile_link_color":"1B95E0","profile_sidebar_border_color":"FFFFFF","profile_sidebar_fill_color":"F6F6F6","profile_text_color":"333333","profile_use_background_image":true,"has_extended_profile":true,"default_profile":false,"default_profile_image":false,"pinned_tweet_ids":[],"pinned_tweet_ids_str":[],"has_custom_timelines":true,"can_media_tag":null,"followed_by":null,"following":null,"follow_request_sent":null,"notifications":null,"advertiser_account_type":"promotable_user","advertiser_account_service_levels":["dso","dso","media_studio","dso"],"business_profile_state":"none","translator_type":"regular","require_some_consent":false}

```

other endpoint
```text
https://api.twitter.com/1.1/followers/ids.json
https://api.twitter.com/1.1/followers/list.json
https://api.twitter.com/1.1/friends/ids.json
..etc 

https://developer.twitter.com/en/docs/accounts-and-users/follow-search-get-users/overview

```

## example bypass public key api-limit
```php
use koulab\UltimateTwitter\Proxy;
use koulab\UltimateTwitter\Client;
$proxy = new Proxy();
$proxy->addAddress('socks5://127.0.0.1:9150');
$proxy->addAddress('http://lum-customer-.....-zone-static-ip-..:password@zproxy.lum-superproxy.io:22225');
$proxy->addAddress('http://lum-customer-.....-zone-static-ip-..:password@zproxy.lum-superproxy.io:22225');

$to = new Client($proxy);
$response = $to->get('https://api.twitter.com/1.1/users/show.json?screen_name=twitter');
print_r($response);

```
