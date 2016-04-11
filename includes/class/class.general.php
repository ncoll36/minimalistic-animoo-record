<?php

    /**
     * This class contains all operations
     *
     * Class General
     */
    class General {
        
        private $link;
        
        /**
         * Constructs a new database connection for this class
         */
        public function __construct() {
            $this->link = connection();
        }
        
        
        /**
         * Retrieves all anime data
         */
        public function getAnime($order, $type) {
            $query = $this->link->prepare("SELECT *
                                           FROM anime");
            try {
                $query->execute();
                if ($type == 3) {
                    return $query->fetchAll(PDO::FETCH_COLUMN, 2);
                } else {
                    return $this->returnAnime($query->fetchAll(), $order, $type);
                }
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }


        /**
         * Creates anime table
         */
        public function returnAnime($anime, $order, $type) {
            if (!empty($anime)) { 
                $sort = array_column($anime, $type);
                array_multisort($sort, $order, $anime);

                foreach ($anime as $a) {
                    if ($a["folder"]) {
                        $folder = ' ';
                    } else {
                        $folder = '<div class="no-folder" id="' . $a["id"] . '"><i class="fa fa-folder-open-o" id="' . $a["id"] . '"></i></div>';
                    }
                    echo '<div class="row">
                              <div class="name">' . $a["name"] . $folder . '</div>
                              <div class="number" id="' . $a["id"] . '">' . $a["number"] . '</div>
                              <div class="add" id="' . $a["id"] . '"></div>
                              <div class="minus" id="' . $a["id"] . '"></div>
                              <div class="delete" id="' . $a["id"] . '"></div>
                          </div>';
                }
            } else {
                echo '<div class="row">
                          <div class="name">No Anime Exist!</div>
                          <div class="blank"></div>
                          <div class="blank"></div>
                          <div class="blank"></div>

                      </div>';
            }
        }


        /**
         * Sorts Anime
         * $order: 0 = ASC | 1 = DESC
         * $type: 0 = Alpha | 1 = Number
         */
        public function sortAnime($order, $type) {
            if ($order == 0) {
                $n_order = SORT_ASC;
            } elseif ($order == 1) {
                $n_order = SORT_DESC;
            }

            if ($type == 0) {
                $n_type = 'name';
            } elseif ($type == 1) {
                $n_type = 'number';
            }
            return $this->getAnime($n_order, $n_type);
        }


        /**
         * Gets the total number of anime
         * $type: 3 = Count
         */
        public function countAnime() {
            $order = 0;
            $type = 3;
            $anime = $this->getAnime($order, $type);
            echo array_sum($anime);
        }


        /**
         * Increase anime number
         */
        public function changeNumber($id, $exec) {
            $query = $this->link->prepare("SELECT number
                                           FROM anime
                                           WHERE id = ?");
            $query->bindValue(1, $id);

            try {
                $query->execute();
                $number = $query->fetch();
                if ($exec == 0) {
                    $number = $number["number"] + 1;
                } elseif ($exec == 1) {
                    if ($number["number"] > 1) {
                        $number = $number["number"] - 1;
                    } else {
                        $number = $number["number"];
                    }
                }

                $query = $this->link->prepare("UPDATE anime 
                                               SET number = :number
                                               WHERE id = :id");
                $query->bindParam(':number', $number, PDO::PARAM_INT); 
                $query->bindParam(':id', $id, PDO::PARAM_INT); 

                try {
                    $query->execute();
                    echo $number;

                } catch (PDOException $e) {
                    die($e->getMessage());
                }

                
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
    

        /**
         * Searches for anime by name 
         */
        public function keywordSeach($keyword) {
            $keyword = $keyword . '%';
            $query = $this->link->prepare("SELECT *
                                           FROM anime
                                           WHERE name LIKE ?");
            $query->bindValue(1, $keyword);

            try {
                $query->execute();
                return $this->returnAnime($query->fetchAll(), SORT_ASC, 'name');
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }


        /**
         * Searches for anime by number 
         */
        public function numberSeach($number) {
            /*$number = $number . '%';*/
            $query = $this->link->prepare("SELECT *
                                           FROM anime
                                           WHERE number = ?");
            $query->bindValue(1, $number);

            try {
                $query->execute();
                return $this->returnAnime($query->fetchAll(), SORT_ASC, 'name');
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }


        /**
         * Adds new anime
         */
        public function addAnime($name, $number, $folder) {
            $name = ucfirst($name);
            $query = $this->link->prepare("INSERT INTO anime(name, number, folder)
                                           VALUES (:name, :number, :folder)");
            $query->bindParam(':name', $name); 
            $query->bindParam(':number', $number);
            $query->bindParam(':folder', $folder); 
            try {
                $query->execute();
                return $this->getAnime(SORT_ASC, 'name');
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }


        /**
         * Deletes anime
         */
        public function deleteAnime($id) {
            $query = $this->link->prepare("DELETE FROM anime
                                           WHERE id = ?");
            $query->bindValue(1, $id);
            try {
                $query->execute();
                return $this->getAnime(SORT_ASC, 'name');
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }


        /**
         *Login
         */
        public function login($username, $password) {
            $username = stripslashes($username);
            $password = stripslashes($password);
            $username = mysql_real_escape_string($username);
            $password = mysql_real_escape_string($password);
            $password = hash(sha256, $password);


            $query = $this->link->prepare("SELECT *
                                           FROM users
                                           WHERE username = ?
                                           AND password = ?");
            $query->bindValue(1, $username);
            $query->bindValue(2, $password);
            try {
                $query->execute();
                $count = count($query->fetchAll());
                if ($count == 1) {
                    $_SESSION['login'] = true;
                    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
                    /*header("location:index.php");*/
                } else {
                    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=login.php">';
                    /*header("location:login.php");*/
                }
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }


        /**
         * Updates folder value to TRUE
         */
        public function updateFolder($id) {
            $folder = true;
            $query = $this->link->prepare("UPDATE anime 
                                           SET folder = :folder
                                           WHERE id = :id");
            $query->bindParam(':folder', $folder, PDO::PARAM_BOOL); 
            $query->bindParam(':id', $id, PDO::PARAM_INT); 

            try {
                return $query->execute();

            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
    }
?>