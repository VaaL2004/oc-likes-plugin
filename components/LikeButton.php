<?php namespace Xl1034\Likes\Components;

use Cms\Classes\ComponentBase;
use October\Rain\Exception\ApplicationException;
use October\Rain\Exception\SystemException;
use RainLab\User\Facades\Auth;
use Xl1034\Likes\Models\Like;
use Lang;

class LikeButton extends ComponentBase
{


    private $likeable_type;
    private $likeable_id;
    public $likes;


    public function componentDetails()
    {
        return [
            'name' => 'xl1034.likes::lang.plugin.components.likebuttons.title',
            'description' => 'xl1034.likes::lang.plugin.components.likebuttons.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'likeable_type' => [
                'title' => 'xl1034.likes::lang.plugin.components.likebuttons.likeable_type',
                'type' => 'string',
            ],
            'likeable_id' => [
                'title' => 'xl1034.likes::lang.plugin.components.likebuttons.likeable_id',
                'default' => 1,
                'type' => 'string',
                'validationPattern' => '^[0-9]+$'
            ]
        ];
    }


    protected function prepareVars()
    {


    }


    public function onRun()
    {
        $this->setLikableType($this->property('likeable_type'));
    }


    public function onRender()
    {
        $this->likeable_id = $this->page['likeable_id'] = $this->property('likeable_id');
        $this->page['rating'] = $this->getRating($this->likeable_type, $this->likeable_id);
    }


    public function onLike()
    {
        if (!Auth::check()) {
            throw new ApplicationException(Lang::get('xl1034.likes::lang.plugin.components.likebuttons.unregistred'));
        }


        $set_dislike = post('is_dislike') == 0 ? 0 : 1;


        $like = $this->getLike();

        if ($like != null) {

            if ($set_dislike) {
                if ($like->is_dislike == 1) {
                    $like->delete();
                    $this->page['rating'] = $this->getRating($this->likeable_type, $this->likeable_id);
                    return;
                } else {
                    $like->is_dislike = 1;
                    $like->save();
                    $this->page['rating'] = $this->getRating($this->likeable_type, $this->likeable_id);
                    return;
                }
            } else {
                if ($like->is_dislike == 0) {
                    $like->delete();
                    $this->page['rating'] = $this->getRating($this->likeable_type, $this->likeable_id);
                    return;
                } else {
                    $like->is_dislike = 0;
                    $like->save();
                    $this->page['rating'] = $this->getRating($this->likeable_type, $this->likeable_id);
                    return;
                }
            }
        }


        $user = Auth::user();

        Like::create([
            'is_dislike' => $set_dislike,
            'user_id' => $user->id,
            'likeable_id' => $this->likeable_id,
            'likeable_type' => $this->likeable_type
        ]);

        $this->page['rating'] = $this->getRating($this->likeable_type, $this->likeable_id);
    }


    private function getLike()
    {
        $user = Auth::user();

        $this->setLikableType($this->property('likeable_type'));
        $this->likeable_id = $this->page['likeable_id'] = (int)post('id');


        return Like::where('likeable_type', $this->likeable_type)
            ->where('likeable_id', $this->likeable_id)
            ->where('user_id', $user->id)->first();
    }


    private function getRating($likeable_type, $likeable_id)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $myLike = Like::where('likeable_type', $likeable_type)->where('likeable_id', $likeable_id)->where('user_id', $user->id)->first();
            if ($myLike) {
                $this->page['my_like'] = $myLike->is_dislike == 0 ? 'like' : 'dislike';
            }
        }

        $likes = Like::where('likeable_type', $likeable_type)->where('likeable_id', $likeable_id)->where('is_dislike', 0)->count();
        $dislikes = Like::where('likeable_type', $likeable_type)->where('likeable_id', $likeable_id)->where('is_dislike', 1)->count();
        return $likes - $dislikes;
    }


    private function setLikableType(?string $property)
    {
        if (class_exists($property)) {
            $this->likeable_type = $property;
        } else {
            throw new SystemException('Likeable Class doesn\'t exists');
        }

    }


}
