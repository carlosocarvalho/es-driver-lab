<?php

return [
    'indices' =>
        [
            'clippings' =>
                [
                    'label' => 'Clipping',
                    'shortname' => '14',
                    'name'   =>'clippings',
                    'priority' => 1,
                    'types' => [
                        [
                            'name' => 'clipping',
                            'label' => 'Estudos Deloitte',
                            'priority' => 1,
                        ],
                        [
                            'name' => 'risk',
                            'label' => 'Risk Alert',
                            'priority' => 2,
                        ],
                        [
                            'name' => 'taxalert',
                            'label' => 'Tax Alert',
                            'priority' => 3,
                        ]
                    ]
                ],
            'livros' =>
                [
                    'label' => 'Livros',
                    'shortname' => '22',
                    'name'   =>'livros',
                    'priority' => 2,
                    'types' => [
                        [
                            'name' => 'livro',
                            'label' => 'Livro',
                            'priority' => 1,
                        ],
                        [
                            'name' => 'capitulo',
                            'label' => 'Capitulo',
                            'priority' => 2,
                        ]
                    ]
                ],

            'knowledges' =>
                [
                    'label' => 'Knowledge',
                    'shortname' => 'knowledges',
                    'name'   =>'knowledges',
                    'priority' => 2,
                    'types' => [
                        [
                            'name' => 'knowledge',
                            'label' => 'Knowledge Management',
                            'priority' => 1,
                        ]
                    ]
                ],
            'periodicos' =>
                [
                    'label' => 'Periódicos',
                    'shortname' => '27',
                    'priority' => 3,
                    'name'   =>'periodicos',
                    'types' => [
                        [
                            'name' => 'artigo',
                            'label' => 'Artigo',
                            'priority' => 1,
                        ],
                        [
                            'name' => 'periodico',
                            'label' => 'Revista',
                            'priority' => 2,
                        ],

                    ]
                ],
            'parecers' => [
                'label'      => 'Pareceres',
                'shortname'  => 'parecers',
                'name'       => 'parecers',
                'priority'   => 3,
                'types' => [
                    [
                        'name' => 'parecer',
                        'label' => 'Parecer',
                        'priority' => 1,
                    ],

             ]
            ],

                'kardexs' => [
                'label'      => 'Senhas',
                'shortname'  => 'kardexs',
                'name'       => 'kardexs',
                'priority'   => 4,
                'types' => [
                    [
                        'name' => 'password',
                        'label' => 'Senhas',
                        'priority' => 1,
                    ],
                     [
                        'name' => 'signature',
                        'label' => 'Assinaturas',
                        'priority' => 2,
                    ],

                ]

            ]

        ],
    'fields' =>[
       '9A','19','46','59A','80E','10A', '10B','20A','20B','30A','30B','35T','40A','40B','50A','50B','60A','80A','80B','80C','100A','110A','111A','245A','245B','245P',
       '245S','247A','247B','260A','260B','260C','270','275','320','490A','490D','490N','490V','500','503','505','520','590','591','650','697','700A','710A','720S','773D',
       '773T','800T','800G','800N','800P','903','922','260Y','933','936D','936S','973','981','998','991','993','995','996','997','999','300','80D','90','41','300A',
    ],

    'fields_in' =>[

        'index','type','260Y',
        '9A','19','46','59A','80E','10A', '10B','20A','20B','30A','30B','35T','40A','40B','50A','50B','60A','80A','80B','80C','100A','110A','111A','245A','245B','245P','300A',
       '245S','247A','247B','260A','260B','260C','270','275','320','490A','490D','490N','490V','500','503','505','520','590','591','650','697','700A','710A','720S','773D','41',
       '773T','800T','800G','800N','800P','903','922','933','936D','936S','973','981','998','991','993','995','996','997','999','comments','likes','thumbnail','extras','777','300','80D','90'
    ],
    'fields_string'=>[
        'index','type',
        '999','987',
        '777','245A',
        '41','245B',
        '260Y','247A',
        '247B','800G',
        '22','260C',
        '260D','260M',
        '260D','300A',
        'extras','260S',
        '263A','263M',
        '263D','773T',
        '21','13',
        'thumbnail',
        'extras','856B',
        '270','970C',
        '300','90',
        '80D'
    ],
    'elasticsearchSettingIndex' =>
        [
            'settings' =>
                [
                    'analysis' => [

                        "filter" => [
                            'stemmer_plural_portugues' => [
                                'type' => 'stemmer',
                                "name" => "minimal_portuguese"
                            ]
                            /*
                             "brazilian_stop"=>[
                                 "type" =>"stop",
                                 "stopwords" =>"_brazilian_"
                             ],
                             'brazilian_keywords' => [
                                 'type' => 'keyword_marker',
                                 'keywords' => [],
                                 'keywords_path' => '/usr/share/elasticsearch/data/brazilian.txt'
                             ],
                             'brazilian_stemmer' => [
                                 'type' => 'stemmer',
                                 'language'=> 'brazilian'

                             ]*/

                        ],
                        'analyzer' => [
                            'brazilian' => [
                                'tokenizer' => 'standard',
                                'filter' => [
                                    'lowercase', 'asciifolding'
                                ]
                            ]
                        ]
                    ]
                ],
            'mappings' =>
                [
                    '_default_' =>
                        [
                            'properties' =>
                                [

                                    '9A' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '19' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '16' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '46' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '59A' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '80E' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '10A' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],

                                    '10B' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '20A' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],

                                    '20B' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '30A' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],

                                    '30B' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '35T' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],

                                    '40A' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],

                                    '40B' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '50A' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],

                                    '50B' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '60A' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                     '80D' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '80A' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '80B' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '80C' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],

                                    '100A' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '110A' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '111A' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '245A' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '245B' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '245P' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '245S' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '247A' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '247B' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '260A' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '260B' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '260C' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '270' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '275' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '320' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '490A' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '490D' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '490N' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '490V' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '500' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '503' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '505' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '520' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '590' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '591' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '650' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '697' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '700A' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '710A' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '720S' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '773D' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '773T' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '800T' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '800G' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '800N' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '800P' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '903' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '922' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '933' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '936D' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '936S' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '973' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '981' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '998' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '991' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '993' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '995' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '996' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '997' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                    '999' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'brazilian',
                                                ]
                                            ]
                                        ],
                                        'thumbnail' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                        ],
                                        'digital' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                        ],
                                    'likes' =>
                                        [
                                            'type' => 'integer'


                                        ],
                                    'comments' =>
                                        [
                                            'type' => 'integer',


                                        ],
                                    '901A' =>
                                        [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'index' => 'not_analyzed',

                                        ],
                                    '777' =>
                                        [
                                            'type' => 'integer'
                                        ],
                                ],
                        ],
                ],
        ],
        'callbacks'=>[
                'index'=>[],
                'type'=>[],
                '260Y'=>[],
                '9A'=>['toArrayABCD'],
                '19'=>['toArrayABCD'],
                '46'=>['toArrayABCD'],
                '59A'=>['toArrayABCD'],
                '80E'=>['toArrayABCD'],
                '10A'=>['toArrayABCD'], 
                '10B'=>['toArrayABCD'],
                '20A'=>['toArrayABCD'],
                '20B'=>['toArrayABCD'],
                '30A'=>['toArrayABCD'],
                '30B'=>['toArrayABCD'],
                '35T'=>['toArrayABCD'],
                '40A'=>['toArrayABCD'],
                '40B'=>['toArrayABCD'],
                '50A'=>['toArrayABCD'],
                '50B'=>['toArrayABCD'],
                '60A'=>['toArrayABCD'],
                '80A'=>['toArrayABCD'],
                '80B'=>['toArrayABCD'],
                '80C'=>['toArrayABCD'],
                '100A'=>['toArrayABCD'],
                '110A'=>['toArrayABCD'],
                '111A'=>['toArrayABCD'],
                '245A'=>['toArrayABCD'],
                '245B'=>['toArrayABCD'],
                '245P'=>['toArrayABCD'],
                '300A'=>['toArrayABCD'],
                '245S'=>['toArrayABCD'],
                '247A'=>['toArrayABCD'],
                '247B'=>['toArrayABCD'],
                '260A'=>['toArrayABCD'],
                '260B'=>['toArrayABCD'],
                '260C'=>['toArrayABCD'],
                '270'=>['toArrayABCD'],
                '275'=>['toArrayABCD'],
                '320'=>['toArrayABCD'],
                '490A'=>['toArrayABCD'],
                '490D'=>['toArrayABCD'],
                '490N'=>['toArrayABCD'],
                '490V'=>['toArrayABCD'],
                '500'=>['toArrayABCD'],
                '503'=>['toArrayABCD'],
                '505'=>['toArrayABCD'],
                '520'=>['toArrayABCD'],
                '590'=>['toArrayABCD'],
                '591'=>['toArrayABCD'],
                '650'=>['toArrayABCD'],
                '697'=>['toArrayABCD'],
                '700A'=>['toArrayABCD'],
                '710A'=>['toArrayABCD'],
                '720S'=>['toArrayABCD'],
                '773D'=>['toArrayABCD'],
                '777' =>['validateToDateABCD'],
                '41'=>[],
                '773T'=>['toArrayABCD'],
                '800T'=>['toArrayABCD'],
                '800G'=>['toArrayABCD'],
                '800N'=>['toArrayABCD'],
                '856B'=>['toArrayABCD'],
                '800P'=>['toArrayABCD'],
                '903'=>['toArrayABCD'],
                '901A'=>['toArrayABCD'],
                '922'=>['toArrayABCD'],
                '933'=>['toArrayABCD'],
                '936D'=>['toArrayABCD'],
                '936S'=>['toArrayABCD'],
                '973'=>['toArrayABCD'],
                '981'=>['toArrayABCD'],
                '998'=>['toArrayABCD'],
                '991'=>['toArrayABCD'],
                '993'=>['toArrayABCD'],
                '995'=>['toArrayABCD'],
                '996'=>['toArrayABCD'],
                '997'=>['toArrayABCD'],
                'digital'=>['toArrayABCD'],
                '999'=>[],
                'comments'=>[],
                'likes'=>[],
                'thumbnail'=>[],
                'extras'=>[],
                '777'=>['validateToDateABCD'],
                '300'=>[],
                '80D'=>[],
                '90'=>[]
        ],
        'addDefaultFields'=>[
            '777'=>['defaultValue'=>null],
            'comments'=>['defaultValue'=>0],
            'likes'=>['defaultValue'=>0],
            'extras'=>['defaultValue'=>null]
        ]
];
