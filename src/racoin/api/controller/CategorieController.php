<?php

namespace racoin\api\controller;


use \racoin\common\model\Categorie;

class CategorieController extends AbstractController
{
    public function getAllCategories()
    {
        $query = Categorie::select('id', 'libelle');
        $allCategories = $query->get();
        return $this->jsonResponse($allCategories, 200);
    }

    public function getCategorieById($id)
    {
        $categorieById = Categorie::find($id);
        return $this->jsonResponse($categorieById, 200);
    }

    public function getCategorieByAnnonce($annonce)
    {
        $query = Categorie::join('annonce', 'categorie.id', '=', 'annonce.cat_id')
            ->select('categorie.id', 'categorie.libelle', 'categorie.descriptif')
            ->where('annonce.id', '=', $annonce);
        $categorie = $query->get();

        return $this->jsonResponse($categorie, 200);
    }
}