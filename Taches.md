Côtés Clients Manoa:
    - Solde:
        - backend:
            - model utilisé: ( ClientModel )
                - requete: select(solde)->where(client_id)

    - controller utilisé: ( ClientController )
                - view (client/solde)
        - frontend:
            - views/client/solde

    - Depot/Transfert/Retrait:
        - backend:
            - model utilisé: ( operateurModel, prefixModel, fraisModel, TypeOperation, OperationModel)
                - requete: insert (OperationModel)
                            update ( compte_source, solde + montant envoye ) => si transfert
                            update ( compte_destination, solde - montant envoye ) => si transfert

    update (compte_source, solde - montant pris) => si retrait

    update (compte_destination, solde + montant envoye) => si depot
            - controller utilisé: (OperationController)
        - frontend:
            - views/client/transaction-form + js ( si !transfert => disabled input destination )

    - Hisorique des transactions:
        - backend:
            - model utilisé: ( ClientModel )
                - requete: table(historique_details)->select(*)

    - controller utilisé: ( ClientController )
                - view (client/solde)

    - frontend:
            - views/client/solde

Cote operateur (Model, Controlleur, View avec Login) Kevin

Cote operateur (Kevin):

    - login:

    - gestion des operateurs entrant (filtre si l'operateur est de la campagnie ou non)

    - gestion des clients entrant (filtre si le client vient de la campagnie ou non)

    - Affichage des montants a anvoyer a chaque operateur

Cote client (Manoa):

- modification js: ajout des input type radio + verification montant a paye
- controller: verification du compte destinataire si appartient a la campagnie (si oui, pas de commission)
- modification js: ajout de numero multiple
- controller: insertion de la transaction + verification si les numeros appartiennent a la campagnie
