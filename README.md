Youtube
=========

![Travis Youtube Build](https://api.travis-ci.org/Gonda/GondaYoutube.svg?branch=master)

Laravel PHP Facade/Wrapper for the Youtube Data API v3 ( Non-OAuth )

## Requirements

- PHP 7.2 or higher
- Laravel 6.0 or higher
- API key from [Google Console](https://console.developers.google.com)

Looking for Youtube Package for either of these: PHP 5, Laravel 5.0, Laravel 4? Visit the [`php5-branch`](https://github.com/gonda/GondaYoutube/tree/php5)

## Installation

Run in console below command to download package to your project:
```
composer require rajagonda/gondayoutube
```

## Configuration

In `/config/app.php` add GondaYoutubeServiceProvider:
```
Rajagonda\GondaYoutube\GondaYoutubeServiceProvider::class,
```

Do not forget to add also Youtube facade there:
```
'GondaYoutube' => Rajagonda\GondaYoutube\Facades\GondaYoutube::class,
```

Publish config settings:
```
$ php artisan vendor:publish --provider="Rajagonda\GondaYoutube\GondaYoutubeServiceProvider"
```

Set your Youtube API key in the file:

```
/config/gondayoutube.php
```

Or in the .env file
```
YOUTUBE_API_KEY = KEY
```

Or you can set the key programmatically at run time :
```
GondaYoutube::setApiKey('KEY');
```

## Usage

```php
// use Rajagonda\GondaYoutube\Facades\GondaYoutube;


// Return an STD PHP object
$video = GondaYoutube::getVideoInfo('rie-hPVJ7Sw');

// Get multiple videos info from an array
$videoList = GondaYoutube::getVideoInfo(['rie-hPVJ7Sw','iKHTawgyKWQ']);

// Get multiple videos related to a video
$relatedVideos = GondaYoutube::getRelatedVideos('iKHTawgyKWQ');

// Get comment threads by videoId
$commentThreads = GondaYoutube::getCommentThreadsByVideoId('zwiUB_Lh3iA');

// Get popular videos in a country, return an array of PHP objects
$videoList = GondaYoutube::getPopularVideos('us');

// Search playlists, channels and videos. return an array of PHP objects
$results = GondaYoutube::search('Android');

// Only search videos, return an array of PHP objects
$videoList = GondaYoutube::searchVideos('Android');

// Search only videos in a given channel, return an array of PHP objects
$videoList = GondaYoutube::searchChannelVideos('keyword', 'UCk1SpWNzOs4MYmr0uICEntg', 40);

// List videos in a given channel, return an array of PHP objects
$videoList = GondaYoutube::listChannelVideos('UCk1SpWNzOs4MYmr0uICEntg', 40);

$results = GondaYoutube::searchAdvanced([ /* params */ ]);

// Get channel data by channel name, return an STD PHP object
$channel = GondaYoutube::getChannelByName('xdadevelopers');

// Get channel data by channel ID, return an STD PHP object
$channel = GondaYoutube::getChannelById('UCk1SpWNzOs4MYmr0uICEntg');

// Get playlist by ID, return an STD PHP object
$playlist = GondaYoutube::getPlaylistById('PL590L5WQmH8fJ54F369BLDSqIwcs-TCfs');

// Get playlists by multiple ID's, return an array of STD PHP objects
$playlists = GondaYoutube::getPlaylistById(['PL590L5WQmH8fJ54F369BLDSqIwcs-TCfs', 'PL590L5WQmH8cUsRyHkk1cPGxW0j5kmhm0']);

// Get playlist by channel ID, return an array of PHP objects
$playlists = GondaYoutube::getPlaylistsByChannelId('UCk1SpWNzOs4MYmr0uICEntg');

// Get items in a playlist by playlist ID, return an array of PHP objects
$playlistItems = GondaYoutube::getPlaylistItemsByPlaylistId('PL590L5WQmH8fJ54F369BLDSqIwcs-TCfs');

// Get channel activities by channel ID, return an array of PHP objects
$activities = GondaYoutube::getActivitiesByChannelId('UCk1SpWNzOs4MYmr0uICEntg');

// Retrieve video ID from original YouTube URL
$videoId = GondaYoutube::parseVidFromURL('https://www.youtube.com/watch?v=moSFlvxnbgk');
// result: moSFlvxnbgk
```

## Basic Search Pagination

```php
// Set default parameters
$params = [
    'q'             => 'Android',
    'type'          => 'video',
    'part'          => 'id, snippet',
    'maxResults'    => 50
];

// Make intial call. with second argument to reveal page info such as page tokens
$search = GondaYoutube::searchAdvanced($params, true);

// Check if we have a pageToken
if (isset($search['info']['nextPageToken'])) {
    $params['pageToken'] = $search['info']['nextPageToken'];
}

// Make another call and repeat
$search = GondaYoutube::searchAdvanced($params, true);

// Add results key with info parameter set
print_r($search['results']);

/* Alternative approach with new built-in paginateResults function */

// Same params as before
$params = [
    'q'             => 'Android',
    'type'          => 'video',
    'part'          => 'id, snippet',
    'maxResults'    => 50
];

// An array to store page tokens so we can go back and forth
$pageTokens = [];

// Make inital search
$search = GondaYoutube::paginateResults($params, null);

// Store token
$pageTokens[] = $search['info']['nextPageToken'];

// Go to next page in result
$search = GondaYoutube::paginateResults($params, $pageTokens[0]);

// Store token
$pageTokens[] = $search['info']['nextPageToken'];

// Go to next page in result
$search = GondaYoutube::paginateResults($params, $pageTokens[1]);

// Store token
$pageTokens[] = $search['info']['nextPageToken'];

// Go back a page
$search = GondaYoutube::paginateResults($params, $pageTokens[0]);

// Add results key with info parameter set
print_r($search['results']);
```

The pagination above is quite basic. Depending on what you are trying to achieve you may want to create a recursive function that traverses the results.

## Run Unit Test
If you have PHPUnit installed in your environment, run:

```bash
$ phpunit
```

If you don't have PHPUnit installed, you can run the following:

```bash
$ composer update
$ ./vendor/bin/phpunit
```

## Format of returned data
The returned JSON is decoded as PHP objects (not Array).
Please read the ["Reference" section](https://developers.google.com/youtube/v3/docs/) of the Official API doc.


## Youtube Data API v3
- [Youtube Data API v3 Doc](https://developers.google.com/youtube/v3/)
- [Obtain API key from Google API Console](https://console.developers.google.com)


## Credits
Built on code from Madcoda's [php-youtube-api](https://github.com/madcoda/php-youtube-api).
