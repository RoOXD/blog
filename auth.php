<?php
function hashUserID($id)
{
    $key="14011999";
    return hash_hmac('md5', $id, $key);
}
  
  function encodeUserID($id)
  {
      $hash = hashUserID($id);
      return "$id.$hash";
  }
  
  function decodeUserID($value)
  {
      $parts = explode(".", $value);
      $id = $parts[0];
      $hash = $parts[1];
      if (hash_equals(hashUserID($id), $hash)) {
          return 1;
      }
      return 0;
  }
