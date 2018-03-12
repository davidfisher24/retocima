<?php

namespace App\Traits;

trait TextSearch
{
    /**
     * Replaces spaces with full text search wildcards
     *
     * @param string $term
     * @return string
     */
    
    protected function fullTextWildcards($term)
    {
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $term = str_replace($reservedSymbols, '', $term);
 
        $words = explode(' ', $term);
        $searchTerm = implode( ' ', $words);
 
        return $searchTerm;
    }
   
    /**
     * Scope a query that matches a full text search of term.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $term
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeSearch($query, $term)
    {
        $term = $this->fullTextWildcards($term);
 
        $query->where(function ($q) use ($term) {
          foreach ($this->searchable as $col) {
            $q->orWhere($col, 'like', "%{$term}%");
          }
        })->get();
 
        return $query;
    }
}
