<a name="3.5.6"></a>
## [3.5.6](https://github.com/hypeJunction/hypeLists/compare/3.5.5...v3.5.6) (2016-02-15)


### Bug Fixes

* **js:** make sure $items are set ([2357bf9](https://github.com/hypeJunction/hypeLists/commit/2357bf9))
* **lists:** improve delete logic ([84ea62d](https://github.com/hypeJunction/hypeLists/commit/84ea62d))



<a name="3.5.5"></a>
## [3.5.5](https://github.com/hypeJunction/hypeLists/compare/3.5.4...v3.5.5) (2016-01-25)


### Bug Fixes

* **js:** fix how ajax list data is stored ([8064b74](https://github.com/hypeJunction/hypeLists/commit/8064b74))



<a name="3.5.4"></a>
## [3.5.4](https://github.com/hypeJunction/hypeLists/compare/3.5.3...v3.5.4) (2016-01-25)


### Bug Fixes

* **js:** fix variable name ([a2f3e30](https://github.com/hypeJunction/hypeLists/commit/a2f3e30))

### Features

* **js:** store list data on init and ajax load ([208563b](https://github.com/hypeJunction/hypeLists/commit/208563b))
* **js:** store list data on init and ajax load ([438cced](https://github.com/hypeJunction/hypeLists/commit/438cced))



<a name="3.5.3"></a>
## [3.5.3](https://github.com/hypeJunction/hypeLists/compare/3.5.2...v3.5.3) (2016-01-24)


### Bug Fixes

* **js:** doh, js event name ([e2529c2](https://github.com/hypeJunction/hypeLists/commit/e2529c2))



<a name="3.5.2"></a>
## [3.5.2](https://github.com/hypeJunction/hypeLists/compare/3.5.1...v3.5.2) (2016-01-24)


### Features

* **js:** trigger ready event when list is rendered ([cb472b6](https://github.com/hypeJunction/hypeLists/commit/cb472b6))



<a name="3.5.1"></a>
## [3.5.1](https://github.com/hypeJunction/hypeLists/compare/3.5.0...v3.5.1) (2016-01-24)


### Bug Fixes

* **js:** run initialization script only once ([ee5736e](https://github.com/hypeJunction/hypeLists/commit/ee5736e))



<a name="3.5.0"></a>
# [3.5.0](https://github.com/hypeJunction/hypeLists/compare/3.4.1...v3.5.0) (2016-01-23)


### Features

* **js:** adds more public event triggers ([79dd720](https://github.com/hypeJunction/hypeLists/commit/79dd720))
* **lists:** better handling of empty lists ([cb44929](https://github.com/hypeJunction/hypeLists/commit/cb44929))



<a name="3.4.1"></a>
## [3.4.1](https://github.com/hypeJunction/hypeLists/compare/3.4.0...v3.4.1) (2015-12-28)


### Bug Fixes

* **js:** always trigger initialize event after AMD module is loaded ([8397e61](https://github.com/hypeJunction/hypeLists/commit/8397e61))
* **js:** correctly parse loader CSS class when spinner is not loaded ([5d21c65](https://github.com/hypeJunction/hypeLists/commit/5d21c65)), closes [#16](https://github.com/hypeJunction/hypeLists/issues/16)



<a name="3.4.0"></a>
# [3.4.0](https://github.com/hypeJunction/hypeLists/compare/3.3.2...v3.4.0) (2015-12-27)


### Bug Fixes

* **api:** fix default list id ([00e2add](https://github.com/hypeJunction/hypeLists/commit/00e2add))
* **css:** clean up CSS and get rid of SASS ([012cd43](https://github.com/hypeJunction/hypeLists/commit/012cd43))
* **css:** css makes no sense, get rid of it ([4793c25](https://github.com/hypeJunction/hypeLists/commit/4793c25))
* **delete:** ajax delete now respects confirmations response ([1d20ce3](https://github.com/hypeJunction/hypeLists/commit/1d20ce3)), closes [#12](https://github.com/hypeJunction/hypeLists/issues/12)
* **deps:** hypeApps is not really required, get rid of it ([1463bef](https://github.com/hypeJunction/hypeLists/commit/1463bef))
* **js:** clean AMD module structure ([08adf28](https://github.com/hypeJunction/hypeLists/commit/08adf28))
* **lists:** lists now do not break in non-default viewtypews ([79039e8](https://github.com/hypeJunction/hypeLists/commit/79039e8)), closes [#14](https://github.com/hypeJunction/hypeLists/issues/14)
* **lists:** properly handle no results ([9e811df](https://github.com/hypeJunction/hypeLists/commit/9e811df)), closes [#8](https://github.com/hypeJunction/hypeLists/issues/8)

### Features

* **events:** trigger a change event whenever items visibility is toggled ([1834a89](https://github.com/hypeJunction/hypeLists/commit/1834a89)), closes [#13](https://github.com/hypeJunction/hypeLists/issues/13)
* **spinner:** use Elgg spinner module if available ([0bb2f6f](https://github.com/hypeJunction/hypeLists/commit/0bb2f6f))



<a name="3.3.2"></a>
## [3.3.2](https://github.com/hypeJunction/hypeLists/compare/3.3.2...v3.3.2) (2015-12-27)




<a name="3.3.2"></a>
## [3.3.2](https://github.com/hypeJunction/hypeLists/compare/3.3.1...3.3.2) (2015-10-20)


### Bug Fixes

* **manifest:** grunt needs type attribute ([993097d](https://github.com/hypeJunction/hypeLists/commit/993097d))



<a name="3.3.1"></a>
## [3.3.1](https://github.com/hypeJunction/hypeLists/compare/3.3.0...3.3.1) (2015-10-20)


### Bug Fixes

* **js:** use inline require to load amd modules on ajax ([5af7386](https://github.com/hypeJunction/hypeLists/commit/5af7386))



<a name="3.3.0"></a>
# [3.3.0](https://github.com/hypeJunction/hypeLists/compare/3.2.0...3.3.0) (2015-08-22)




<a name="3.2.0"></a>
# [3.2.0](https://github.com/hypeJunction/hypeLists/compare/3.1.1...3.2.0) (2015-07-30)


### Bug Fixes

* **amd:** requirejs does not like jquery plugin served from simplecache ([b7672e2](https://github.com/hypeJunction/hypeLists/commit/b7672e2))
* **js:** kill event with die ([c6c8d3a](https://github.com/hypeJunction/hypeLists/commit/c6c8d3a))
* **js:** remove duplicate confirmation dialogs ([7324368](https://github.com/hypeJunction/hypeLists/commit/7324368))
* **js:** remove duplicate confirmation dialogs ([ba51db4](https://github.com/hypeJunction/hypeLists/commit/ba51db4))
* **lists:** treat elgg-gallery as elgg-list ([bd81d7d](https://github.com/hypeJunction/hypeLists/commit/bd81d7d))



<a name="3.1.1"></a>
## [3.1.1](https://github.com/hypeJunction/hypeLists/compare/3.1.0...3.1.1) (2015-07-28)


### Bug Fixes

* **manifest:** fix manifest ([e308ae5](https://github.com/hypeJunction/hypeLists/commit/e308ae5))



<a name="3.1.0"></a>
# [3.1.0](https://github.com/hypeJunction/hypeLists/compare/3.0.0...3.1.0) (2015-07-28)




<a name="3.0.0"></a>
# 3.0.0 (2015-01-12)




