<?

namespace App\Module;

use App\Node;


class Categories extends Model
{
    protected $str = [];

    public function prepareContent()
    {
        $this->data['content'] = [
          [
              'title' => 'Другие услуги',
              'sort' => 999999999,
              'children' => []
          ]
        ];
        $services =
            array_map([Services::class, 'prepareItem'], Node::getList(
                [
                    'filters' => [
                        'public = 1',
                        'parent = 0',
                        'type LIKE "services"',
                    ],
                    'sorters' => [
                        'weight ASC'
                    ]
                ]
            )->getItems());

        foreach ($services as $service) {
            $children = static::getChildren($service->id);

            if(!empty($children)){
                $this->data['content'][] = [
                    'title' => $service->title,
                    'url' => $service->getUrl(),
                    'weight' => $service->weight,
                    'children' => $children
                ];
            }else{
                $this->data['content'][0]['children'][] = $service;
            }
        }

        usort($this->data['content'], function ($a, $b){
            return (int)$a['sort'] <=> (int)$b['sort'];
        });
    }
    public static function getChildren($parentID)
    {
        return array_map([Services::class, 'prepareItem'], Node::getList(
            [
                'filters' => [
                    'public = 1',
                    'type LIKE "services"',
                    sprintf('parent = %s', $parentID)
                ],
                'sorters' => [
                    'weight ASC'
                ]
            ]
        )->getItems());
    }
}