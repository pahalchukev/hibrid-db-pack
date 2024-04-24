<?php

namespace HibridVod\Database\Models\Video\Search;

use ScoutElastic\Migratable;
use ScoutElastic\IndexConfigurator;

class VideosIndexConfigurator extends IndexConfigurator
{
    use Migratable;

    /**
     * @var string
     */
    protected $name = 'vod';

    /**
     * @var array<string, mixed>
     */
    protected $settings = [
        'analysis' => [
            'tokenizer' => [
                'custom_tokenizer' => [
                    'type'        => 'ngram',
                    'min_gram'    => 3,
                    'max_gram'    => 10,
                    'token_chars' => ['letter', 'digit'],
                ],
                "comma_tokenizer" => [
                    "type" => "pattern",
                    "pattern" => ","
                ]
            ],
            'filter'    => [
                'autocomplete_filter' => [
                    'type'     => 'edge_ngram',
                    'min_gram' => 3,
                    'max_gram' => 10,
                ],
                'arabic_stop'         => [
                    'type'      => 'stop',
                    'stopwords' => '_arabic_',
                ],
                'arabic_stemmer'      => [
                    'type'     => 'stemmer',
                    'language' => 'arabic',
                ],
            ],
            'analyzer'  => [
                'autocomplete' => [
                    'type'      => 'custom',
                    'tokenizer' => 'custom_tokenizer',
                    'filter'    => [
                        'lowercase',
                        'autocomplete_filter',
                        'arabic_stop',
                        'arabic_normalization',
                        'arabic_stemmer',
                    ],
                ],
                "custom_comma_analyzer" => [
                    "type" => "custom",
                    "tokenizer" => "comma_tokenizer"
                ],
                'text'         => [
                    'type'      => 'custom',
                    'tokenizer' => 'standard',
                    'filter'    => [
                        'trim',
                        'lowercase',
                        'arabic_stop',
                        'arabic_normalization',
                        'arabic_stemmer',
                    ],
                ],
            ],
        ],
    ];
}
