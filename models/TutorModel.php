<?php

    class TutorModel{

        protected $conn;
        public $rows;
        public $rowsAll;

        public function __construct()
        {
            $this->conn = new Consultas();
        }

        public function get($comparate = null, $value = null)
        {
            $query = $this->conn->getConsultar("
                SELECT *
                FROM tutor
                WHERE $comparate = '$value'
            ");

            while($row = $query->fetch_array(MYSQLI_ASSOC)){
                $this->rows[] = $row;
            }

            return $this->rows;

        }

        public function getAll()
        {
            $query = $this->conn->getConsultar("
                SELECT *
                FROM tutor
            ");

            while($row = $query->fetch_array(MYSQLI_ASSOC)){
                $this->rowsAll[] = $row;
            }

            return $this->rowsAll;
        
        }

        public function set($user, $modify = array())
        {

            $comparateOne = $this->get("user_tutor",$user);
            if(empty($comparateOne)){
                    extract($modify);
                    if($this->conn->getConsultar("
                            INSERT INTO tutor
                            (name_tutor, user_tutor, curp_tutor, sex_tutor, address_tutor, postal_code_tutor, phone_tutor, password_tutor, id_schools)
                            VALUES
                            ('$nombre', '$user', '$curp', '$sex', '$direccion', '$postal', '$telefono', '$pass', '$school')
                        "))
                    {
                        header('Location:'.Rutas::getDireccion('tutor'));
                    }else{
                        exit("El registro no se ha completado por algun motivo");
                    }
            }else{
                exit("El usuario ya existe");
            }
        }

        public function edit($id, $repit, $user, $values = array())
        {
            if($repit == "no"){
                $comparateOne = $this->get("user_tutor",$user);
                if(empty($comparateOne)){
                extract($values);
                    if($this->conn->getConsultar("
                        UPDATE tutor
                        SET name_tutor = '$nombre', user_tutor = '$user', curp_tutor = '$curp', sex_tutor = '$sex', address_tutor = '$direccion', postal_code_tutor = '$postal', phone_tutor = '$telefono', password_tutor = '$pass', id_schools = '$school'
                        WHERE id_tutor = '$id'
                    "))
                    {
                        header('Location:'.Rutas::getDireccion('tutor'));
                    }else
                    {
                        exit("Ocurrio un error en la modificacion");
                    }
                }else{
                    exit("El usuario ya existe");
                }
            }else{
                extract($values);
                    if($this->conn->getConsultar("
                        UPDATE tutor
                        SET name_tutor = '$nombre', user_tutor = '$user', curp_tutor = '$curp', sex_tutor = '$sex', address_tutor = '$direccion', postal_code_tutor = '$postal', phone_tutor = '$telefono', password_tutor = '$pass', id_schools = '$school'
                        WHERE id_tutor = '$id'
                    "))
                    {
                        header('Location:'.Rutas::getDireccion('tutor'));
                    }else
                    {
                        exit("Ocurrio un error en la modificacion");
                    }
            }
        }

        public function delete($id)
        {
            if($this->conn->getConsultar("
                DELETE FROM tutor
                WHERE id_tutor = '$id'
            ")){
                header('Location:'.Rutas::getDireccion('tutor'));
            }else
            {
                exit("Ocurrio algun error o el archivo ya no existe");
            }
        }
    }


?>