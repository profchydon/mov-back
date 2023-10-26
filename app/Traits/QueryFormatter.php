<?php

namespace App\Traits;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait QueryFormatter
{
    public static function appendValidFiltersToQuery(Builder $query, Request $request, array $validFilters): Builder
    {
        $validFiltersKeyValues = static::getValidFiltersKeyValuesFromRequest($request, $validFilters);

        return static::getQueryWithValidFilters($query, $validFiltersKeyValues);
    }

    protected static function getValidFiltersKeyValuesFromRequest(Request $request, array $validFilters): array
    {
        $validFiltersKeyValues = [];
        $filtersFromRequest = $request->filters ?? [];

        foreach ($filtersFromRequest as $filter => $value) {
            if ($value !== '' && array_key_exists($filter, $validFilters)) {
                $actualFilterCriterion = $validFilters[$filter];
                $validFiltersKeyValues[$actualFilterCriterion] = $value;
            }
        }

        return $validFiltersKeyValues;
    }

    protected static function getQueryWithValidFilters(Builder $newQuery, array $validFiltersKeyValues): Builder
    {
        foreach ($validFiltersKeyValues as $filter => $value) {
            if (is_array($value)) {
                if (isset($value['from']) || isset($value['to'])) {
                    $from = $value['from'] ?? null;
                    $to = $value['to'] ?? null;
                    if (isset($from) && isset($to)) {
                        $newQuery = $newQuery->whereBetween($filter, [$from, $to]);
                    } elseif (isset($from)) {
                        $newQuery = $newQuery->where($filter, '>', $from);
                    } elseif (isset($to)) {
                        $newQuery = $newQuery->where($filter, '<', $to);
                    }
                } else {
                    $newQuery = static::getExactWhereQueryFromArrayData($newQuery, $value, $filter);
                }
            } elseif ($value == 'null') {
                $newQuery = $newQuery->whereNull($filter);
            } else {
                $valueArrays = explode(',', $value);
                $newQuery = static::getExactWhereQueryFromArrayData($newQuery, $valueArrays, $filter);
            }
        }

        return $newQuery;
    }

    private static function getExactWhereQueryFromArrayData(Builder $newQuery, array $valueArrays, string $filter): Builder
    {
        if (count($valueArrays) == 1) {
            $value = $valueArrays[0];
            $newQuery = $newQuery->where($filter, $value);
        } elseif (count($valueArrays) > 1) {
            $newQuery = $newQuery->where(function ($q) use ($valueArrays, $filter) {
                for ($i = 0; $i < count($valueArrays); $i++) {
                    if ($i == 0) {
                        $q = $q->where($filter, $valueArrays[$i]);
                    } else {
                        $q = $q->orWhere($filter, $valueArrays[$i]);
                    }
                }
            });
        }

        return $newQuery;
    }

    protected static function appendValidSearchCriteriaToQuery(Builder $query, Request $request, array $validSearchableCriteria): Builder
    {
        $search = $request->get('search');

        $validSearchableCriteria = collect($validSearchableCriteria);

        if (!$search || $validSearchableCriteria->isEmpty()) {
            return $query;
        }

        $query->where(function (Builder $q) use ($validSearchableCriteria, $search) {
            $validSearchableCriteria->each(function (string $criterion) use ($q, $search) {
                $criterionComponents = explode('.', $criterion);

                $table = with(new static)->getTable();

                if (count($criterionComponents) === 1 || $table == $criterionComponents[count($criterionComponents) - 2]) {
                    $q->orWhere($criterion, 'like', $search . '%');

                    return;
                }

                $property = array_pop($criterionComponents);
                $relation = implode('.', $criterionComponents);

                $q->orWhereRelation($relation, $property, 'like', $search . '%');
            });
        });

        return $query;
    }

    protected static function appendValidHavingCriteriaToQuery(Builder $query, Request $request, array $validHavingCriteria): Builder
    {
        $validHavingKeyValues = static::getValidHavingCriteria($request, $validHavingCriteria);

        return static::getQueryWithValidHavingCriteria($query, $validHavingKeyValues);
    }

    protected static function getValidHavingCriteria(Request $request, array $validHavingCriteria): array
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

    protected static function getQueryWithValidHavingCriteria(Builder $newQuery, array $validHavingKeyValues): Builder
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

    private static function getHavingQueryFromArrayData(Builder $newQuery, array $valueArrays, string $having): Builder
    {
        if (count($valueArrays) == 1) {
            $value = $valueArrays[0];

            if (!isset(static::$exact)) {
                $newQuery = $newQuery->having($having, $value);
            } elseif (in_array($having, static::$exact)) {
                $newQuery = $newQuery->having($having, $value);
            } else {
                $newQuery = $newQuery->having($having, 'like', $value . '%');
            }
        } elseif (count($valueArrays) > 1) {
            for ($i = 0; $i < count($valueArrays); $i++) {
                if ($i == 0) {
                    $newQuery = $newQuery->having($having, $valueArrays[$i]);
                } else {
                    $newQuery = $newQuery->orHaving($having, $valueArrays[$i]);
                }
            }
        }

        return $newQuery;
    }

    protected static function getValidSortDirectionFromRequest(array $sortCriteriaFromRequest): string
    {
        $direction = strtolower($sortCriteriaFromRequest['direction'] ?? 'asc');

        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        return $direction;
    }

    protected static function getQueryWithValidSortCriteria(Builder $newQuery, array $validSortKeyValues): Builder
    {
        foreach ($validSortKeyValues as $filter => $value) {
            $newQuery = $newQuery->orderBy($filter, $value);
        }

        return $newQuery;
    }

    protected static function getValidSortCriteriaKeyValuesFromRequest($request, $validSortableCriteria)
    {
        $validSortCriteriaKeyValues = [];
        $sortCriteriaFromRequest = $request->get('sort') ?? [];
        $criteria = $sortCriteriaFromRequest['field'] ?? null;
        if (!$criteria || !array_key_exists($criteria, $validSortableCriteria)) {
            return $validSortCriteriaKeyValues;
        }
        $criteria = $validSortableCriteria[$criteria];
        $direction = static::getValidSortDirectionFromRequest($sortCriteriaFromRequest);
        $validSortCriteriaKeyValues[$criteria] = $direction;

        return $validSortCriteriaKeyValues;
    }

    public static function appendValidSortCriteriaToQuery(Builder $query, Request $request, array $validSortCriteria): Builder
    {
        $validSortKeyValues = static::getValidSortCriteriaKeyValuesFromRequest($request, $validSortCriteria);

        return static::getQueryWithValidSortCriteria($query, $validSortKeyValues);
    }

    public static function appendToQueryFromRequestQueryParameters(Builder $query): Builder
    {
        $request = request();

        if (isset(static::$filterable)) {
            $query = static::appendValidFiltersToQuery($query, $request, static::$filterable);
        }

        if (isset(static::$searchable)) {
            $query = static::appendValidSearchCriteriaToQuery($query, $request, static::$searchable);
        }

        if (isset(static::$having)) {
            $query = static::appendValidHavingCriteriaToQuery($query, $request, static::$having);
        }

        if (isset(static::$sortable)) {
            $query = self::appendValidSortCriteriaToQuery($query, $request, static::$sortable);
        }

        return $query;
    }
}
