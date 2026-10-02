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

        $mainGroup = CollectionGroup::where('handle', 'principale4')->first();

        $results = $mainGroup
            ?->collections()
            ->whereNull('parent_id')
            ->with([
                'urls',
                'children' => fn ($query) => $query->defaultOrder()->with(['urls', 'children.urls']),
            ])
            ->defaultOrder()
            ->get() ?? collect();

            return $results;

        return view('livewire.navigation-menu', [
            'collections' => $menuCollections,
        ]);        


        $results = CollectionGroup::where('handle', 'principale4')
                        ->first()
                        ?->collections()
                        ->whereNull('parent_id')
                        ->with(['urls', 'children'])
                        ->get() ?? collect();
/*
                        foreach ($results as $collection) {
                            // 1. Dati della Collection Radice (Parent)
                            $nome = $collection->attr('name');
                            $url = $collection->urls->first()?->slug; // o tramite helper/metodo del modello
                        
                            echo "Radice: {$nome}<br>";
                        
                            // 2. Ciclare i figli diretti
                            foreach ($collection->children as $child) {
                                $nomeFiglio = $child->attr('name');
                                echo " └── Figlio: {$nomeFiglio}<br>";
                            }
                        }
                        dd("");                   
                       
        foreach ($results as $collection) {debug($collection);
            debug($collection->translateAttribute('name'));
            if($collection->children->count()) {
                foreach($collection->children as $child) {
                    debug($child->translateAttribute('name'));
                }
            }
        }
        dd("");*/
        return $results;

    }

    public function render(): View
    {
        return view('livewire.components.navigation');
    }
}
