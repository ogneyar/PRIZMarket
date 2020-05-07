<? 
class vk {
    private $token;
    private $app_id;
    private $group_id;
    private $delta;
    public function __construct( $token, $delta = 5, $app_id = 'xxxxxxx', $group_id = 'xxxxxxxx' ) {
        $this->token = $token;
        $this->delta = $delta;
        $this->app_id = $app_id;
        $this->group_id = $group_id;
    }
    public function post( $desc, $photo, $link ) {
        if( rand( 0, 99 ) < $this->delta ) {
            $data = json_decode(
                        $this->execute(
                            'wall.post',
                            array(
                                'owner_id' => -$this->group_id,
                                'from_group' => 1,
                                'message' => $desc,
                                'attachments' => 'photo-' . $this->group_id . '_' . $photo . ',' . $link
                            )
                        )
                    );
            if( isset( $data->error ) ) {
                return $this->error( $data );
            }
            return $data->response->post_id;
        }
        return 0;
    }
    public function create_album( $name, $desc ) {
        $data = json_decode(
                    $this->execute(
                        'photos.createAlbum',
                        array(
                            'title' => $name,
                            'gid' => $this->group_id,
                            'description' => $desc,
                            'comment_privacy' => 1,
                            'privacy' => 1
                        )
                    )
                );
        if( isset( $data->error ) ) {
            return $this->error( $data );
        }
        return $data->response->aid;
    }
    public function get_album_size( $id ) {
        $data = json_decode(
                    $this->execute(
                        'photos.getAlbums',
                        array(
                            'oid' => -$this->group_id,
                            'aids' => $id
                        )
                    )
                );
        if( isset( $data->error ) ) {
            return $this->error( $data );
        }
        return $data->response['0']->size;
    }
    public function upload_photo( $file, $album_id, $desc ) {
        if( !is_file( $file ) ) return false;
        $data = json_decode(
                    $this->execute(
                        'photos.getUploadServer',
                        array(
                            'aid' => $album_id,
                            'gid' => $this->group_id,
                            'save_big' => 1
                        )
                    )
                );
        if( isset( $data->error ) ) {
            return $this->error( $data );
        }
        $err['photos.getUploadServer'] = $data;
        $ch = curl_init( $data->response->upload_url );
        curl_setopt ( $ch, CURLOPT_HEADER, false );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt ( $ch, CURLOPT_POST, true );
        //curl_setopt ( $ch, CURLOPT_SAFE_UPLOAD, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, [ 'file1' => new CURLFile($file) ]); //'@' . $file ) );
        $data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode( $data );
        if( isset( $data->error ) ) {
            return $this->error( $data );
        }
        $err['UploadPhoto'] = $data;
        $data = json_decode(
                    $this->execute(
                        'photos.save',
                        array(
                            'aid' => $album_id,
                            'gid' => $this->group_id,
                            'server' => $data->server,
                            'photos_list' => $data->photos_list,
                            'hash' => $data->hash,
                            'caption' => $desc
                        )
                    )
                );
        if( isset( $data->error ) ) {
            $err['photos.save'] = $data;
            return $this->error( $err );
        }
        return $data->response['0']->pid;
    }
    private function execute( $method, $params ) {
        $ch = curl_init( 'https://api.vk.com/method/' . $method . '?access_token=' . $this->token );
        curl_setopt ( $ch, CURLOPT_HEADER, false );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $params );
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    private function error( $data ) {
        var_dump($data);
        return false;
    }
}

?>
