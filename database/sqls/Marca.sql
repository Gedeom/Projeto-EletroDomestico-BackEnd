INSERT INTO marca(id,descricao, created_at, updated_at) VALUES
                                                           (1, 'Electrolux', now(), now()),
                                                           (2, 'Brastemp', now(), now()),
                                                           (3, 'Fischer', now(), now()),
                                                           (4, 'Samsung', now(), now()),
                                                           (5, 'LG', now(), now())
ON DUPLICATE KEY UPDATE id=id
;
