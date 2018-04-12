[![Build Status](https://api.travis-ci.org/Lendable/VisitorTrackingBundle.svg)](https://travis-ci.org/Lendable/VisitorTrackingBundle)

Visitor Tracking Bundle
=======================

A Symfony bundle to track requests.

## Upgrading from 0.x to 1.x

The main difference is the move to multiple A/B testing seeds connected to a lifetime.
You will probably want to run some kind of migration like:

`INSERT INTO seed SELECT NULL, id, 'default', seed FROM lifetime`

`ALTER TABLE lifetime DROP seed`

You can then get the old seed by doing `$lifetime->getSeed('default')`
