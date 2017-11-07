Visitor Tracking Bundle
=======================

A Symfony2 bundle to track the requests.

## Upgrading from 0.x to 1.x

The main difference is the move to multiple A/B testing seeds connected to a lifetime.
You will probably want to run some kind of migration like:

INSERT INTO seed SELECT NULL, id, 'default', seed FROM lifetime

ALTER TABLE lifetime DROP seed

You can then get the old seed by doing $lifetime->getSeed('default')