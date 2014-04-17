#Vera 

_a Powerful Wechat Public Account support framework with high extendibility_

    the lastest version is v2.0


##Abstract

This is a powerful Wechat public account support framework.

It has some features like this

+ It's light and fast.
+ It can serve many accounts at the same time.
+ It's very easy to develop plugin.


##Install

####Step 1

you need to copy all files to your server folder and make sure you can reach the folder through url.

####Step 2

set your server url on Wechat dashboard

    https://mp.weixin.qq.com

then just click the button and Wechat Public Platform will do the rest and give you an answer

then you can test on your wechat or use test tools provided by Wechat Public Platform.

####Step 3

import mysql.sql to your MySQL database.

set your database info in configure.php.

_if you want to use ./plugin/route.php , you also need to fill in BaiduAccessKey in configure.php_

####Step 4

try "博客" or "blog".

you will receive my blog info in Chinese

try "注册"+昵称 you can registe as a VIP

_Because I use Baidu map API, so if you want to use ./plugin/route.php you need to set your latitude and longitude in database ,then send your location and you will get a route from your position to where you set in database._

####Step 5

try to develop your own plugin for Vera !

you can use my plugins as a example.


##Author Info

writen by Yuri. You are warmly welcome to develop plugin for it.

My blog : [代码仔的实验室](http://www.yurilab.com/blog/1) (Chinese)

if you have any problem just mail to <zhang1437@gmail.com> I wiil reply in two days.

I'm looking for internship and part-time jobs now. Just mail me please. : )


##What's next ?

I'm working on Vera v3.0 these days. Actually I've already use v2.0 for nearly two monthes and I think I can make it more powerful and add some new features to it.

Now I'm designing the framework v3.0 . I want to add some mods such as Queue, Log, Cache etc. 