# CakePHP Chatwork Plugin

Build Status Latest Stable Version License

※CakePHP - 当 Chatwork Plugin は Chatwork API (2017-05-05 時点のプレビュー版) による実装です。

# 本家 (Official)

- CakePHP - http://cakephp.org/
- Chatwork - http://www.chatwork.com/
- Chatwork API - http://developer.chatwork.com/ja/

# 必要環境 (Requirements)

master ブランチの必要環境 (The master branch has the following requirements)

- CakePHP CakePHP 3.1.3 以降. (CakePHP 3.1.3 or greater.)
- PHP 5.6.0 以降. (PHP 5.6.0 or greater.)

# インストール (Installation)

`app/plugins/Chatwork` ディレクトリにコピーするか、`git clone` でファイルを格納してください。

(Clone/Copy the files in this directory into `app/plugins/Chatwork`)

git の場合は `git submodule` コマンドが便利です。

(This can be done with the `git submodule` command)

```sh
git submodule add https://github.com/sirone/chatwork_cakephp.git app/plugins/Chatwork
```

`app/config/bootstrap.php` にて、`Plugin::load('Chatwork', ['bootstrap' => true, 'autoload' => true]);` のようにプラグインを読み込んでください。

(Ensure the plugin is loaded in `app/cnfig/bootstrap.php` by calling `Plugin::load('Chatwork', ['bootstrap' => true, 'autoload' => true]);`)

# ドキュメント(Documentation)

## 設定(Configuration)

Chatwork Plugins の設定ファイルの元は、`/app/plugins/Chatwork/config/bootstrap.php.default` にあります。

(A copy of ChatworkPlugin’s bootstrap file is found in `/app/plugins/Chatwork/config/bootstrap.php.default`.)

同一ディレクトリ上にこのファイルのコピーを作り、 `bootstrap.php` という名前にしてください。

(Make a copy of this file in the same directory, but name it `bootstrap.php`.)

設定ファイルの中身は一目瞭然です。 `API_TOKEN` 定数の値を自分のセットアップに合わせて変更するだけです。

(The config file should be pretty straightforward: just replace the values in the `API_TOKEN` constant with those that apply to your setup.)

例は次のようなものになるでしょう:

(A sample configuration constant might look something like the following:)

```php
define(__NAMESPACE__.'\API_TOKEN','X-ChatWorkToken:1s2a3m4p5l6e7h8a9h10a11');
```

この定数が `Chatwork` 名前空間に属していることに注意してください。

( Please note that it belongs to the `Chatwork` namespace...)

http://php.net/manual/en/language.namespaces.php



## 書きかけ (now writing... sorry)

BTC:39wFc9Zj8xgasyG2iGRE4RdRFEWSEXvzax
