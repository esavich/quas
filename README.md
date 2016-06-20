# quas

[![Build Status](https://travis-ci.org/weeoi/quas.svg?branch=master)](https://travis-ci.org/weeoi/quas)

PHP Text Template Engine

# Example
```php
$template = 'Lorem [ipsum~dolor~sit] {amet <var1>}, {consectetur <!var2>} adipisicing elit. Adipisci beatae dolores [eum|eveniet|fugiat hic|ipsum iste(3@;)]';

$data = [
    'var1' => 'test'
];

$q = new \Quas();

$text = $q->compile($template, $data);
```

# Overview
Generate text from template. Commonly used in SEO optimizations.

# Syntax
```
[ ch1 | ch1 (1@,)]
[ ch1 ~ ch2 (N@,)]
```
Select single (|) or concatenate all (~) random choices, if limit (N) not specified.
If limit is set, this two rules behave the same.

`N` - number of choices in result string; `@` - special symbol; all other symbols until ')' used as a separator for concatenated choices.
Negative numbers can be used. In that case LEN - N variants will be used (where LEN is length of choice list).

`<var>` - Variable. Simply replaced with supplied value.

`{text <var>}` - Print text only if variable set and not empty.

`{text <!var>}` - Print text only if variable not set or empty.

`{text <=var (value)>}` - Print text only if variable equal to value.

`{text <!=var (value)>}` - Print text only if variable not equal to value.

Multiple vars can be set in same rule; in that case they use and(&) relations.

# Modifiers
Modifiers could be applied BEFORE any expression and will affect on result of this expression (including all nested values).

Possible modifiers:

|     |                              |
|-----|------------------------------|
| `@` | Do not print result of expression |
| `^` | Convert first letter of evaluated expression to upper case | 
| `*` | Convert first letter of evaluated expression to lower case |

# Tests
> Require [phpunit](https://phpunit.de) to run.

Run tests with

```sh
$ phpunit tests
```

# Contributing
*[WIP]*

# License
Distributed under MIT license. See [LICENSE](LICENSE) for reference.