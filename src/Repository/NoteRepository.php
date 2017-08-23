<?php

namespace Repository;

use Entity\Movie;
use Entity\Note;
use Entity\User;

class NoteRepository extends RepositoryAbstract
{
    protected function getTable()
    {
        return 'movie_note'; 
    }
    
    private function buildEntity(array $data)
    {
        $user = new User();
        
        $user
            ->setId_user($data['id_user'])
        ;
        
        $movie = new Movie();
        
        $movie
            ->setId($data['id_movie']);
        
        
        
        $note = new Note(); 
        
        $note
            ->setId_movie_note($data['id_movie_note'])
            ->setUser($user)
            ->setNote($data['note'])
            ->setMovie($movie)
        ;
        return $note; 
    }
    
    public function findByMovies($id) 
    {
        $dbNotes = $this->db->fetchAll(
            'SELECT * FROM movie_note mn '
                . 'JOIN movies m ON m.id_movie = mn.id_movie '
                . 'JOIN users u ON u.id_user = mn.id_user '
                . 'WHERE m.id_movie = :id '
                . 'AND id_movie_note = ('
                    . 'SELECT MAX(id_movie_note) '
                    . 'FROM movie_note '
                    . 'WHERE id_user = mn.id_user)',
                    
            [
                ':id' => $id
            ]
        );
        
        $notes = [];
        
        foreach($dbNotes AS $dbNote)
        {
            $note = $this->buildEntity($dbNote);
            
            $notes[] = $note;
        }
        
        return $notes;
    }
    
    public function save(Note $note)
    {
        // les données à enregistrer en BDD
        $data = [
            //  On utilise les méthodes définies dans Entity Review, une fois que les objets $movie et $user ont été créés en propriété
            'id_user'  => $note->getIdUser(),
            'id_movie'  => $note->getIdMovie(),
            'note'  => $note->getNote(),
        ];
        
        // si le commentaire a un id, on est en update
        // sinon en insert
        $where = !empty($note->getId_movie_note())
        ? ['id_movie_note' => $note->getId_movie_note()]
        : null; 
        
        // appel à la méthode en Repository\Abstract pour enregistrer
        $this->persist($data, $where);
        
        // on set l'id quand on est en insert
        if (empty($note->getId_movie_note()))
        {
            $note->setId_movie_note($this->db->lastInsertId());
        }
    }
    
    public function moyenneByMovie($id)
    {
        $moyennes = $this->db->fetchAll(
            'SELECT ROUND(AVG(mn.note),1) AS moyenne '
                . 'FROM movie_note mn '
                . 'JOIN movies m ON m.id_movie = mn.id_movie '
                . 'WHERE m.id_movie = :id '
                . 'GROUP BY mn.id_movie',
                
            [
                ':id' => $id
            ]
        );
        
        return $moyennes;
    }
    
}
