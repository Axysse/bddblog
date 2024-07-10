<?php 

class Posts 
{
    private $contenu;

    public function setContenu($contenu){
        $this->contenu = $contenu;
    }

    public function getContenu(): string
    {
        return $this->contenu;
}

}