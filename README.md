[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Lendable/VisitorTrackingBundle/badges/quality-score.png)](https://scrutinizer-ci.com/g/Lendable/VisitorTrackingBundle/?branch=master)
[![Build Status](https://api.travis-ci.org/Lendable/VisitorTrackingBundle.svg?branch=master)](https://www.travis-ci.org/Lendable/VisitorTrackingBundle)
[![Coverage Status](https://coveralls.io/repos/github/Lendable/VisitorTrackingBundle/badge.svg?branch=master)](https://coveralls.io/github/Lendable/VisitorTrackingBundle?branch=master)
[![Latest Stable Version](https://poser.pugx.org/lendable/visitor-tracking-bundle/version)](https://packagist.org/packages/lendable/visitor-tracking-bundle)
[![Total Downloads](https://poser.pugx.org/lendable/visitor-tracking-bundle/downloads)](https://packagist.org/packages/lendable/visitor-tracking-bundle)

Visitor Tracking Bundle
=======================

A Symfony bundle to track requests.

## Upgrading from 0.x to 1.x

The main difference is the move to multiple A/B testing seeds connected to a lifetime.
You will probably want to run some kind of migration like:

`INSERT INTO seed SELECT NULL, id, 'default', seed FROM lifetime`

`ALTER TABLE lifetime DROP seed`

You can then get the old seed by doing `$lifetime->getSeed('default')`
