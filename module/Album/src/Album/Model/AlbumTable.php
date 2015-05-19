<?php
    namespace Album\Model;

    use Zend\Db\ResultSet\ResultSet;
    use Zend\Db\TableGateway\TableGateway;
    use Zend\Db\Sql\Select;
    use Zend\Paginator\Adapter\DbSelect;
    use Zend\Paginator\Paginator;
    use Zend\Session\Container; 

    class AlbumTable
    {
        protected $tableGateway;

        public function __construct(TableGateway $tableGateway)
        {
            $this->tableGateway = $tableGateway;
        }

        public function fetchAll($paginated=false, $orderby=null, $way=null)
        {
            //DebugBreak();
            $selectParamsSession = new Container('criteria');
            
            // create a new Select object for the table album
            $select = new Select('album');
            if ($orderby!=null && $way!=null) {
                $select->order($orderby.' '.$way);    
            }
            if($selectParamsSession->offsetExists('searchStr')) {
               $search =  $selectParamsSession->searchStr;
               $select->where->like('artist', '%'.$search.'%')->or->like('title', '%'.$search.'%');
            }
            
            if ($paginated) {
               
                // create a new result set based on the Album entity
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Album());
                // create a new pagination adapter object
                $paginatorAdapter = new DbSelect(
                 // our configured select object
                 $select,
                 // the adapter to run it against
                 $this->tableGateway->getAdapter(),
                 // the result set to hydrate
                 $resultSetPrototype
                );
                $paginator = new Paginator($paginatorAdapter);
                return $paginator;
            }
            
            $resultSet = $this->tableGateway->selectWith($select);
            return $resultSet;
        }

        public function getAlbum($id)
        {
            $id  = (int) $id;
            $rowset = $this->tableGateway->select(array('id' => $id));
            $row = $rowset->current();
            if (!$row) {
             throw new \Exception("Could not find row $id");
            }
            return $row;
        }

        public function saveAlbum(Album $album)
        {
            $data = array(
             'artist' => $album->artist,
             'title'  => $album->title,
             'img'    => $album->img
            );

            $id = (int) $album->id;
            if ($id == 0) {
            $this->tableGateway->insert($data);
            } else {
                if ($this->getAlbum($id)) {
                     $this->tableGateway->update($data, array('id' => $id));
                } else {
                     throw new \Exception('Album id does not exist');
                }
            }
        }

        public function deleteAlbum($id)
        {
            $this->tableGateway->delete(array('id' => (int) $id));
        }
}
?>
