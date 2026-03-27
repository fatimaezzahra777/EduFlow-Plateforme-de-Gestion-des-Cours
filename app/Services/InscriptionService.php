<?php

namespace App\Services;

use App\Models\Inscription;
use App\Models\Course;
use App\Models\Group;

class InscriptionService
{
    public function inscri($courseId)
    {
        $user = auth()->user();

        $exists = Inscription::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->exists();

        if ($exists) {
            throw new \Exception('Déja inscrire');
        }

        $group = Group::where('course_id', $courseId)
            ->withCount('inscription')
            ->having('inscription_count', '<', 25)
            ->first();

        
        if (!$group) {
            $group = Group::create([
                'course_id' => $courseId
            ]);
        }

     
        $inscription = Inscription::create([
            'user_id' => $user->id,
            'course_id' => $courseId,
            'group_id' => $group->id
        ]);

        return $inscription->load('course', 'group');
    }

    public function myInscription()
    {
        return auth()->user()
            ->inscriptions()
            ->with('course', 'group')
            ->get();
    }

    public function cancel($id)
    {
        $inscription = Inscription::findOrFail($id);

        if ($inscription->user_id !== auth()->id()) {
            throw new \Exception('Unauthorized');
        }

        $inscription->delete();

        return ['message' => 'Inscription cancelled'];
    }
}


