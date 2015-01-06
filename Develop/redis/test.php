<?php
require_once 'redis.php';
require_once 'redis.pool.php';
require_once 'redis.peer.php';
 
$redis_pool = array(
    'master' => array('full.host.name', 6379)
);
 
# Redis init
redis_pool::add_servers($redis_pool);
 
class note extends redis_peer{}
 
$note = new note();
 
# Create note, primary key is generated automatically
$id = $note->insert( array('title' => 'Hello', 'body' => 'world!') );
 
# Update note
$id = $note->update( $id, array('body' => 'php!') );
 
# Get some note by primary key
$note_data = $note->get_by_id( $id );
 
# Delete note
$note->delete( $id );