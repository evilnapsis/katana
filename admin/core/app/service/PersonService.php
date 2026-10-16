<?php
namespace App\Service;

/**
 * Clase PersonService
 * 
 * Capa de servicio encargada de la logica de negocio y operaciones CRUD
 * para el modulo de Personas.
 */
class PersonService {
    /**
     * Obtiene el listado completo de personas
     * @return \PersonData[]
     */
    public function getAllPersons(): array {
        return \PersonData::all();
    }

    /**
     * Obtiene una persona por su identificador unico
     * @param int $id ID de la persona
     * @return \PersonData|null
     */
    public function getPersonById(int $id) {
        return \PersonData::find($id);
    }

    /**
     * Crea y persiste una nueva persona en la base de datos
     * @param array $data Datos de la persona (name, lastname, email, phone, address)
     * @return bool Estado de la operacion
     */
    public function createPerson(array $data): bool {
        $person = new \PersonData();
        $person->name = $data['name'] ?? '';
        $person->lastname = $data['lastname'] ?? '';
        $person->email = $data['email'] ?? '';
        $person->phone = $data['phone'] ?? '';
        $person->address = $data['address'] ?? '';
        
        return $person->save();
    }

    /**
     * Actualiza los datos de una persona existente
     * @param int $id ID de la persona a editar
     * @param array $data Datos actualizados
     * @return bool Estado de la operacion
     */
    public function updatePerson(int $id, array $data): bool {
        $person = \PersonData::find($id);
        if (!$person) return false;

        $person->name = $data['name'] ?? $person->name;
        $person->lastname = $data['lastname'] ?? $person->lastname;
        $person->email = $data['email'] ?? $person->email;
        $person->phone = $data['phone'] ?? $person->phone;
        $person->address = $data['address'] ?? $person->address;

        return $person->save();
    }

    /**
     * Elimina una persona por su identificador unico
     * @param int $id ID de la persona a eliminar
     * @return bool Estado de la operacion
     */
    public function deletePerson(int $id): bool {
        $person = \PersonData::find($id);
        if (!$person) return false;

        return $person->delete();
    }
}
