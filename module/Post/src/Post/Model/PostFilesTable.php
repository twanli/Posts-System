<?php
namespace Post\Model;



use Zend\Db\TableGateway\TableGateway;

class PostFilesTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getPostFile($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('file_id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    

    public function savePostFile(PostFiles $postFile)
    {
        $data = array(
            'file_id' => $postFile->file_id,
            'file_post_id'  => $postFile->file_post_id,
            'file_new_name' => $postFile->file_new_name,
            'file_old_name'  => $postFile->file_old_name,
        );

        $id = (int) $postFile->file_id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getPostFile($id)) {
                $this->tableGateway->update($data, array('file_id' => $id));
            } else {
                throw new \Exception('File id does not exist');
            }
        }
    }

    public function deletePostFile($id)
    {
        $this->tableGateway->delete(array('file_id' => (int) $id));
    }
}
?>
