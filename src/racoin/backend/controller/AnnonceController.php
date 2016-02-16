<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 19/01/16
 * Time: 16:27
 */

namespace racoin\backend\controller;

use \racoin\common\model\Annonce;

class AnnonceController extends AbstractController
{
    public function getUnvalidatedAnnounces()
    {
        $template = $this->app->getContainer()->get('twig')->loadTemplate('unvalidated_announce.html');

        $annonces = Annonce::select('id', 'titre', 'prix', 'date_online')->where('status', '=', 1)->get();

        return $template->render(array('annonces' => $annonces));
    }

    public function getAnnounceById($id)
    {
        $annonce = Annonce::select('id', 'titre', 'prix', 'date_online', 'ville', 'descriptif', 'mail_a', 'tel_a')
            ->where('status', '=', 2)
            ->where('id', '=', $id)
            ->get();

        if (!empty($annonce[0])) {
            $template = $this->app->getContainer()->get('twig')->loadTemplate('announce.html');
            return $template->render(array('annonce' => $annonce));
        } else {
            $template = $this->app->getContainer()->get('twig')->loadTemplate('error.html');
            $tab = ['titre' => 'Erreur',
                'message' => 'Annonce inexistante ou non valide.'];
            return $template->render(array('error' => $tab));
        }
    }

    public function validateAnnounceById($id)
    {
        $annonce = Annonce::find($id);

        if (!empty($annonce)) {
            $template = $this->app->getContainer()->get('twig')->loadTemplate('error.html');
            $annonce->status = 2;
            $annonce->save();
            $tab = ['titre' => 'Success',
                'message' => 'Annonce validée !'];
            return $template->render(array('error' => $tab));
        } else {
            $template = $this->app->getContainer()->get('twig')->loadTemplate('error.html');
            $tab = ['titre' => 'Erreur',
                'message' => 'Annonce inexistante ou non valide.'];
            return $template->render(array('error' => $tab));
        }
    }

    public function deleteAnnounceById($id)
    {
        $annonce = Annonce::find($id);

        if (!empty($annonce)) {
            $template = $this->app->getContainer()->get('twig')->loadTemplate('error.html');
            $annonce->status = 3;
            $annonce->save();
            $tab = ['titre' => 'Success',
                'message' => 'Annonce supprimée !'];
            return $template->render(array('error' => $tab));
        } else {
            $template = $this->app->getContainer()->get('twig')->loadTemplate('error.html');
            $tab = ['titre' => 'Erreur',
                'message' => 'Annonce inexistante ou non valide.'];
            return $template->render(array('error' => $tab));
        }
    }
}
