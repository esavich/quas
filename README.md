# quas

[![Build Status](https://travis-ci.org/weeoi/quas.svg?branch=master)](https://travis-ci.org/weeoi/quas)

PHP Text Template Engine

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

`{text \<var>}` - Print text only if variable set and not empty.

`{text !\<var>}` - Print text only if variable not set or empty.

Multiple vars can be set in same rule; in that case they use and(&) relations.
Also vars could be nested, like `<var<var1<var2>>>`. They will be interpolated from deepest to closest and set as final variable name.
In current example if we have var123='test', var1=12, and var2=3, it will return 'test'.

# Tests
> Require [phpunit](https://phpunit.de) to run.

Run tests with

```sh
$ phpunit tests
```

# Contributing
*[WIP]*

#License
Distributed under MIT license. See [LICENSE](LICENSE) for reference.