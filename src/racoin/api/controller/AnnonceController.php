<?php

namespace racoin\api\controller;


use \racoin\common\model\Annonce;
use racoin\common\model\Categorie;

class AnnonceController extends AbstractController
{
    public function getAllAnnonces()
    {
        $query = Annonce::select('id', 'titre', 'prix', 'date_online')
            ->where('status', '=', '1')
            ->orderBy('prix', 'desc');
        if (isset($_GET['min'])) {      //prix Min
            $query->where('prix', '>=', $_GET['min']);
        }
        if (isset($_GET['max'])) {      //prix Max
            $query->where('prix', '<=', $_GET['max']);
        }
        if (isset($_GET['mot'])) {      //par mot clé
            $mot = $_GET['mot'];
            $query->where('titre', 'LIKE', "%$mot%");
        }
        $allAnnonces = $query->get();

        return $this->jsonResponse($allAnnonces, 200);
    }

    public function getAnnonceById($id)
    {
        $query = Annonce::select('id', 'titre', 'prix', 'date_online')
            ->where('id', '=', $id);
        $annoncesById = $query->get();

        return $this->jsonResponse($annoncesById, 200);
    }

    public function getAnnonceByCategorie($catId)
    {
        $query = Annonce::select('id', 'titre', 'prix', 'date_online')
            ->where('status', '=', '1')
            ->where('cat_id', '=', $catId);
        if (isset($_GET['min'])) {      //prix Min
            $query->where('prix', '>=', $_GET['min']);
        }
        if (isset($_GET['max'])) {      //prix Max
            $query->where('prix', '<=', $_GET['max']);
        }
        if (isset($_GET['mot'])) {      //par mot clé
            $mot = $_GET['mot'];
            $query->where('titre', 'LIKE', "%$mot%");
        }
        $annonceByCategorie = $query->get();

        return $this->jsonResponse($annonceByCategorie, 200);
    }

    public function getAnnonceur($id)
    {
        $query = Annonce::select('ville', 'code_postal', 'nom_a', 'prenom_a', 'mail_a', 'tel_a')
            ->where('id', '=', $id);
        $annonceur = $query->get();

        return $this->jsonResponse($annonceur, 200);
    }

    public function postAnnonce(){

        $cat_id = Categorie::select('*')
            ->where('id', '=', $this->request->getParam('cat_id'))
            ->count();

        if ($cat_id == 0) {
            $tab = array('messageErreur' => 'La catégorie est inexistante.');

            $data = json_encode($tab);

            return $this->jsonResponse($data, 404);
        } else {
            $annonce = new Annonce();
            $annonce->titre = $this->request->getParam('titre');
            $annonce->descriptif = $this->request->getParam('descriptif');
            $annonce->ville = $this->request->getParam('ville');
            $annonce->code_postal = $this->request->getParam('codepostal');
            $annonce->prix = $this->request->getParam('prix');
            $annonce->passwd = $this->request->getParam('password');
            $annonce->cat_id = $this->request->getParam('cat_id');

            $annonce->save();

            return $this->jsonResponse($annonce, 201);
        }
    }

    public function deleteAnnonceById($id)
    {
        $query = Annonce::find($id);
        $query->status = 3;
        $query->save();
    }
}