# FacturationV0
API destinée à faciliter la facturation pour les professionnels de santé en cours de développement.

A ce jour, les routes sont fonctionnelles, les requêtes fonctionnent.

Reste à faire : sécurisation de l'accès à l'API via authentification et token + mise en place de tests 

URI :
Les URI serviront à détailler nos requêtes aussi précisément que nécessaire.
Entité par entité, cela donne :
•	Praticien :
-	Pour Read : GET/Praticien

•	Patient :
-	Pour Create : POST/Patients
-	Pour Read : GET/Patients/{patient_id} (id permet de retrouver un patient en particulier)
-	Pour Update : PUT/Patients/{patient_id}
-	Pour Delete : DELETE/Patients/{patient_id} 

•	Rdv :
-	Pour Create : POST/Rdvs
-	Pour Read : GET/Rdvs/{rdv_id} 
-	Pour Update : PUT/ Rdvs/{rdv_id}
-	Pour Delete : DELETE/ Rdvs/{rdv_id} 

•	Facture :
-	Pour Create : POST/Factures
-	Pour Read : GET/Factures/{facture_id} 
-	Pour Delete : DELETE/Factures/{facture_id}


# FacturationV0 : 
API intended to facilitate billing for healthcare professionals under development.

To date, the routes are functional, the requests are working.

Still to be done: securing access to the API via authentication and token + implementation of tests

URI:
The URIs will be used to detail our requests as precisely as necessary.
Entity by entity, this gives:
• Praticien:
- For Read: GET/Praticien

•	Patient :
- For Create: POST/Patients
- For Read: GET/Patients/{patient_id} (id allows you to find a particular patient)
- For Update: PUT/Patients/{patient_id}
- For Delete: DELETE/Patients/{patient_id}

• Rdv:
- For Create: POST/Rdvs
- For Read: GET/Rdvs/{rdv_id}
- For Update: PUT/Rdvs/{rdv_id}
- For Delete: DELETE/ Rdvs/{rdv_id}

•	facture :
- For Create: POST/Factures
- For Read: GET/Factures/{facture_id}
- For Delete: DELETE/Factures/{facture_id}

