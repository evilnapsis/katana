# Modelos de Katana Pro

Los modelos de la base de datos se encuentran centralizados en:
`admin/core/app/model/`

La tienda pública consume y autocarga estos modelos de manera transparente y unificada mediante `Model::getFullpath()`.
No dupliques modelos en este directorio. Cualquier nuevo modelo debe agregarse en `admin/core/app/model/`.
