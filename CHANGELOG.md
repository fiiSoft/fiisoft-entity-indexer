# Changelog

All important changes to `fiisoft-entity-indexer` will be documented in this file

## 1.3.0

Changed way how multiple indexes store keys and significantly changed parts of code
responsible for fetching keys from null indexes.

## 1.2.0

Improved search for entities with null values in indexed properties.

## 1.1.0

Important change - now entities can be indexed by values that can be null.
In this case, entity will not be directly indexed by index, but still will be indexed by ID
and can be searched in many ways (in worst case full searching will be performed).

## 1.0.0

Fully functional release.

## 0.2.0

* added class EntityMapStatsViewAggregator 
* added new param to constructor of EntityMapWithStats
* added method toArray() to EntityMapStatsView
* added abstract class BaseEntityMapStatsView

## 0.1.0

First version - need tests in real world...