<?php

namespace App\Traits;

use Exception;

trait QueryFormatter
{
    public static function appendValidSearchCriteriaToQuery($query, $request, $validSearchableCriteria)
    {
        if (empty($query) || empty($request)) {
            throw new Exception('Query object and/or request object should not be empty');
        }

        $value = $request->get('search') ?? null;
        if (!$value || (count($validSearchableCriteria) === 0)) {
            return $query;
        }
        foreach ($validSearchableCriteria as $criterion) {
            $query = $query->orHaving($criterion, 'like', '%' . $value . '%');
        }

        return $query;
    }

    public static function appendValidHavingCriteriaToQuery($query, $request, $validHavingCriteria)
    {
        if (empty($query) || empty($request)) {
            throw new Exception('Query object and/or request object should not be empty');
        }
        $validHavingKeyValues = static::getValidHavingCriteria($request, $validHavingCriteria);
        $newQuery = static::getQueryWithValidHavingCriteria($query, $validHavingKeyValues);

        return $newQuery;
    }

    public static function getValidHavingCriteria($request, $validHavingCriteria)
    {
        $validHavingKeyValues = [];
        $filtersFromRequest = $request->filters ?? [];
        foreach ($filtersFromRequest as $filter => $value) {
            if ($value !== '' && array_key_exists($filter, $validHavingCriteria)) {
                $actualFilterCriterion = $validHavingCriteria[$filter];
                $validHavingKeyValues[$actualFilterCriterion] = $value;
            }
        }

        return $validHavingKeyValues;
    }

    protected static function getQueryWithValidHavingCriteria($newQuery, $validHavingKeyValues)
    {
        foreach ($validHavingKeyValues as $having => $value) {
            if (is_array($value)) {
                if (isset($value['from']) || isset($value['to'])) {
                    $from = $value['from'] ?? null;
                    $to = $value['to'] ?? null;
                    if (isset($from) && isset($to)) {
                        $newQuery = $newQuery->havingBetween($having, [$from, $to]);
                    } elseif (isset($from)) {
                        $newQuery = $newQuery->having($having, '>', $from);
                    } elseif (isset($to)) {
                        $newQuery = $newQuery->having($having, '<', $to);
                    }
                } else {
                    $newQuery = static::getHavingQueryFromArrayData($newQuery, $value, $having);
                }
            } else {
                $valueArrays = explode(',', $value);
                $newQuery = static::getHavingQueryFromArrayData($newQuery, $valueArrays, $having);
            }
        }

        return $newQuery;
    }

    private static function getHavingQueryFromArrayData($newQuery, $valueArrays, $having)
    {
        if (count($valueArrays) == 1) {
            $value = $valueArrays[0];
            if (in_array($having, static::$exact)) {
                $newQuery = $newQuery->having($having, $value);
            } else {
                $newQuery = $newQuery->having($having, 'like', '%' . $value . '%');
            }
        } elseif (count($valueArrays) > 1) {
            $queryString = '(';
            for ($i = 0; $i < count($valueArrays); $i++) {
                $valueString = addslashes($valueArrays[$i]);
                if ($i == 0) {
                    $queryString .= "{$having} = '{$valueString}'";
                } else {
                    $queryString .= " or {$having} = '{$valueString}'";
                }
            }
            $queryString .= ')';
            $newQuery = $newQuery->havingRaw($queryString);
        }

        return $newQuery;
    }

    public static function appendToQueryFromRequestQueryParameters($query)
    {
        $request = request();
        $query = static::appendValidSearchCriteriaToQuery($query, $request, static::$searchable);
        if (isset(static::$having)) {
            $query = static::appendValidHavingCriteriaToQuery($query, $request, static::$having);
        }

        return $query;
    }
}
