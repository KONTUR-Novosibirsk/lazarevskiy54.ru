<?php

namespace Modules\Feedback\App\Controllers;

use Illuminate\Http\Request;
use Modules\Feedback\App\Feedback\FeedbackConfigFactory;
use Modules\Feedback\App\Models\Feedback;
use Modules\Feedback\App\Resources\FeedbackResource;

class FeedbackController extends \App\Http\Controllers\Controller
{
    public function store(string $name, FeedbackConfigFactory $feedbackFactory, Request $request): FeedbackResource
    {
        if (!$config = $feedbackFactory->getConfig($name)) {
            abort(404);
        }
        $feedback = new Feedback();
        $feedback->setConfig($config);
        $feedback->data = $request->validate($feedback->getRules());
        $feedback->name = $config['name'];
        $feedback->save();
        return new FeedbackResource($feedback);
    }
}
