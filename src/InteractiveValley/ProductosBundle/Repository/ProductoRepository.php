<?php

namespace InteractiveValley\ProductosBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ProductoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductoRepository extends EntityRepository
{
    
    public function getMaxPosicion(){
        $em=$this->getEntityManager();
       
        $query=$em->createQuery('
            SELECT MAX(c.position) as value 
            FROM ProductosBundle:Categoria c 
            ORDER BY c.position ASC
        ');
        
        $max=$query->getResult();
        return $max[0]['value'];
    }
    
    public function findNombreSluggable($slug, $excepto = 0){
        $query= $this->getEntityManager()->createQueryBuilder();
        if($excepto > 0){
            $query->select('p')
                ->from('InteractiveValley\ProductosBundle\Entity\Producto', 'p')
                ->where('p.id<>:producto')
                ->setParameter('producto',$excepto)
                ->andWhere('p.slug LIKE :slug')
                ->setParameter('slug',$slug."%")
                ->orderBy('p.nombre', 'DESC'); 
        }else{
            $query->select('p')
                ->from('InteractiveValley\ProductosBundle\Entity\Producto', 'p')
                ->andWhere('p.slug LIKE :slug')
                ->setParameter('slug',$slug."%")
                ->orderBy('p.nombre', 'DESC'); 
        }
        return $query->getQuery()->getResult();
    }
    
    public function getProductosForModelo($modelo){
        $query= $this->getEntityManager()->createQueryBuilder();
        $query->select('p')
                ->from('InteractiveValley\ProductosBundle\Entity\Producto', 'p')
                ->join('p.modelo', 'm')
                ->where('m.slug=:slug')
                ->setParameter('slug',$modelo->getSlug())
                ->orderBy('p.position', 'ASC');
        return $query->getQuery()->getResult();
    }
}
