<?php

namespace App\Livewire\Components;

use Illuminate\View\View;
use Livewire\Component;
use Lunar\Models\Collection;
use Lunar\Models\CollectionGroup;

class Navigation extends Component
{
    /**
     * The search term for the search input.
     *
     * @var string
     */
    public $term = null;

    /**
     * {@inheritDoc}
     */
    protected $queryString = [
        'term',
    ];

    /**
     * Return the collections in a tree.
     */
    public function getCollectionsProperty()
    {
        // return Collection::with(['defaultUrl'])->get()->toTree();

        $results = CollectionGroup::where('handle', 'main')
                        ->first()
                        ?->collections()
                        ->whereNull('parent_id')
                        ->with(['urls', 'children'])
                        ->get() ?? collect();

        return $results;

    }

    public function render(): View
    {
        return view('livewire.components.navigation');
    }
}
