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


Cote operateur (Model, Controlleur, View avec Login) Kevin:
