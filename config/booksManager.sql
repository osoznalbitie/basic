PGDMP     )                     |            booksManager    15.5    15.5 H    N           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            O           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            P           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            Q           1262    16868    booksManager    DATABASE     �   CREATE DATABASE "booksManager" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_United States.1251';
    DROP DATABASE "booksManager";
                postgres    false            �            1259    16869    author    TABLE     i   CREATE TABLE public.author (
    id integer NOT NULL,
    author_name character varying(255) NOT NULL
);
    DROP TABLE public.author;
       public         heap    postgres    false            �            1259    16872    authors_id_seq    SEQUENCE     �   CREATE SEQUENCE public.authors_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.authors_id_seq;
       public          postgres    false    214            R           0    0    authors_id_seq    SEQUENCE OWNED BY     @   ALTER SEQUENCE public.authors_id_seq OWNED BY public.author.id;
          public          postgres    false    215            �            1259    16873    book    TABLE     �   CREATE TABLE public.book (
    id integer NOT NULL,
    title character varying(100) NOT NULL,
    article character varying(30) NOT NULL,
    arrival_date date NOT NULL,
    author_id integer,
    status smallint DEFAULT 1 NOT NULL
);
    DROP TABLE public.book;
       public         heap    postgres    false            �            1259    16877 
   book_issue    TABLE     �   CREATE TABLE public.book_issue (
    id integer NOT NULL,
    issue_date date NOT NULL,
    book_id integer,
    employee_id integer,
    client_id integer,
    return_deadline date NOT NULL
);
    DROP TABLE public.book_issue;
       public         heap    postgres    false            �            1259    16880    book_issues_id_seq    SEQUENCE     �   CREATE SEQUENCE public.book_issues_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.book_issues_id_seq;
       public          postgres    false    217            S           0    0    book_issues_id_seq    SEQUENCE OWNED BY     H   ALTER SEQUENCE public.book_issues_id_seq OWNED BY public.book_issue.id;
          public          postgres    false    218            �            1259    16881    book_return    TABLE     �   CREATE TABLE public.book_return (
    id integer NOT NULL,
    return_date date NOT NULL,
    book_id integer,
    employee_id integer,
    state_id integer,
    client_id integer,
    book_issue_id integer
);
    DROP TABLE public.book_return;
       public         heap    postgres    false            �            1259    16884    book_returns_id_seq    SEQUENCE     �   CREATE SEQUENCE public.book_returns_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.book_returns_id_seq;
       public          postgres    false    219            T           0    0    book_returns_id_seq    SEQUENCE OWNED BY     J   ALTER SEQUENCE public.book_returns_id_seq OWNED BY public.book_return.id;
          public          postgres    false    220            �            1259    16885 
   book_state    TABLE     k   CREATE TABLE public.book_state (
    id integer NOT NULL,
    state_name character varying(50) NOT NULL
);
    DROP TABLE public.book_state;
       public         heap    postgres    false            �            1259    16888    book_states_id_seq    SEQUENCE     �   CREATE SEQUENCE public.book_states_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.book_states_id_seq;
       public          postgres    false    221            U           0    0    book_states_id_seq    SEQUENCE OWNED BY     H   ALTER SEQUENCE public.book_states_id_seq OWNED BY public.book_state.id;
          public          postgres    false    222            �            1259    16889    books_id_seq    SEQUENCE     �   CREATE SEQUENCE public.books_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.books_id_seq;
       public          postgres    false    216            V           0    0    books_id_seq    SEQUENCE OWNED BY     <   ALTER SEQUENCE public.books_id_seq OWNED BY public.book.id;
          public          postgres    false    223            �            1259    16890    client    TABLE     �   CREATE TABLE public.client (
    id integer NOT NULL,
    full_name character varying(100) NOT NULL,
    passport character varying(10) NOT NULL
);
    DROP TABLE public.client;
       public         heap    postgres    false            �            1259    16893    clients_id_seq    SEQUENCE     �   CREATE SEQUENCE public.clients_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.clients_id_seq;
       public          postgres    false    224            W           0    0    clients_id_seq    SEQUENCE OWNED BY     @   ALTER SEQUENCE public.clients_id_seq OWNED BY public.client.id;
          public          postgres    false    225            �            1259    16894    user    TABLE     �   CREATE TABLE public."user" (
    id integer NOT NULL,
    full_name character varying(255) NOT NULL,
    position_id integer,
    username character varying(255),
    password_hash character varying(255)
);
    DROP TABLE public."user";
       public         heap    postgres    false            �            1259    16899    employees_id_seq    SEQUENCE     �   CREATE SEQUENCE public.employees_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.employees_id_seq;
       public          postgres    false    226            X           0    0    employees_id_seq    SEQUENCE OWNED BY     B   ALTER SEQUENCE public.employees_id_seq OWNED BY public."user".id;
          public          postgres    false    227            �            1259    16900    position    TABLE     o   CREATE TABLE public."position" (
    id integer NOT NULL,
    position_name character varying(100) NOT NULL
);
    DROP TABLE public."position";
       public         heap    postgres    false            �            1259    16903    positions_id_seq    SEQUENCE     �   CREATE SEQUENCE public.positions_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.positions_id_seq;
       public          postgres    false    228            Y           0    0    positions_id_seq    SEQUENCE OWNED BY     F   ALTER SEQUENCE public.positions_id_seq OWNED BY public."position".id;
          public          postgres    false    229            �           2604    16904 	   author id    DEFAULT     g   ALTER TABLE ONLY public.author ALTER COLUMN id SET DEFAULT nextval('public.authors_id_seq'::regclass);
 8   ALTER TABLE public.author ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    215    214            �           2604    16905    book id    DEFAULT     c   ALTER TABLE ONLY public.book ALTER COLUMN id SET DEFAULT nextval('public.books_id_seq'::regclass);
 6   ALTER TABLE public.book ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    223    216            �           2604    16906    book_issue id    DEFAULT     o   ALTER TABLE ONLY public.book_issue ALTER COLUMN id SET DEFAULT nextval('public.book_issues_id_seq'::regclass);
 <   ALTER TABLE public.book_issue ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    218    217            �           2604    16907    book_return id    DEFAULT     q   ALTER TABLE ONLY public.book_return ALTER COLUMN id SET DEFAULT nextval('public.book_returns_id_seq'::regclass);
 =   ALTER TABLE public.book_return ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    220    219            �           2604    16908    book_state id    DEFAULT     o   ALTER TABLE ONLY public.book_state ALTER COLUMN id SET DEFAULT nextval('public.book_states_id_seq'::regclass);
 <   ALTER TABLE public.book_state ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    222    221            �           2604    16909 	   client id    DEFAULT     g   ALTER TABLE ONLY public.client ALTER COLUMN id SET DEFAULT nextval('public.clients_id_seq'::regclass);
 8   ALTER TABLE public.client ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    225    224            �           2604    16910    position id    DEFAULT     m   ALTER TABLE ONLY public."position" ALTER COLUMN id SET DEFAULT nextval('public.positions_id_seq'::regclass);
 <   ALTER TABLE public."position" ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    229    228            �           2604    16911    user id    DEFAULT     i   ALTER TABLE ONLY public."user" ALTER COLUMN id SET DEFAULT nextval('public.employees_id_seq'::regclass);
 8   ALTER TABLE public."user" ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    227    226            <          0    16869    author 
   TABLE DATA           1   COPY public.author (id, author_name) FROM stdin;
    public          postgres    false    214   �Q       >          0    16873    book 
   TABLE DATA           S   COPY public.book (id, title, article, arrival_date, author_id, status) FROM stdin;
    public          postgres    false    216   �Q       ?          0    16877 
   book_issue 
   TABLE DATA           f   COPY public.book_issue (id, issue_date, book_id, employee_id, client_id, return_deadline) FROM stdin;
    public          postgres    false    217   �R       A          0    16881    book_return 
   TABLE DATA           p   COPY public.book_return (id, return_date, book_id, employee_id, state_id, client_id, book_issue_id) FROM stdin;
    public          postgres    false    219   S       C          0    16885 
   book_state 
   TABLE DATA           4   COPY public.book_state (id, state_name) FROM stdin;
    public          postgres    false    221   sS       F          0    16890    client 
   TABLE DATA           9   COPY public.client (id, full_name, passport) FROM stdin;
    public          postgres    false    224   T       J          0    16900    position 
   TABLE DATA           7   COPY public."position" (id, position_name) FROM stdin;
    public          postgres    false    228   �T       H          0    16894    user 
   TABLE DATA           U   COPY public."user" (id, full_name, position_id, username, password_hash) FROM stdin;
    public          postgres    false    226   �T       Z           0    0    authors_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.authors_id_seq', 23, true);
          public          postgres    false    215            [           0    0    book_issues_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.book_issues_id_seq', 27, true);
          public          postgres    false    218            \           0    0    book_returns_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.book_returns_id_seq', 22, true);
          public          postgres    false    220            ]           0    0    book_states_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.book_states_id_seq', 5, true);
          public          postgres    false    222            ^           0    0    books_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.books_id_seq', 51, true);
          public          postgres    false    223            _           0    0    clients_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.clients_id_seq', 6, true);
          public          postgres    false    225            `           0    0    employees_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.employees_id_seq', 28, true);
          public          postgres    false    227            a           0    0    positions_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.positions_id_seq', 4, true);
          public          postgres    false    229            �           2606    16913    book article_unique 
   CONSTRAINT     Q   ALTER TABLE ONLY public.book
    ADD CONSTRAINT article_unique UNIQUE (article);
 =   ALTER TABLE ONLY public.book DROP CONSTRAINT article_unique;
       public            postgres    false    216            �           2606    16915    author authors_pkey 
   CONSTRAINT     Q   ALTER TABLE ONLY public.author
    ADD CONSTRAINT authors_pkey PRIMARY KEY (id);
 =   ALTER TABLE ONLY public.author DROP CONSTRAINT authors_pkey;
       public            postgres    false    214            �           2606    16917    book_issue book_issues_pkey 
   CONSTRAINT     Y   ALTER TABLE ONLY public.book_issue
    ADD CONSTRAINT book_issues_pkey PRIMARY KEY (id);
 E   ALTER TABLE ONLY public.book_issue DROP CONSTRAINT book_issues_pkey;
       public            postgres    false    217            �           2606    16919    book_return book_returns_pkey 
   CONSTRAINT     [   ALTER TABLE ONLY public.book_return
    ADD CONSTRAINT book_returns_pkey PRIMARY KEY (id);
 G   ALTER TABLE ONLY public.book_return DROP CONSTRAINT book_returns_pkey;
       public            postgres    false    219            �           2606    16921    book_state book_states_pkey 
   CONSTRAINT     Y   ALTER TABLE ONLY public.book_state
    ADD CONSTRAINT book_states_pkey PRIMARY KEY (id);
 E   ALTER TABLE ONLY public.book_state DROP CONSTRAINT book_states_pkey;
       public            postgres    false    221            �           2606    16923    book books_pkey 
   CONSTRAINT     M   ALTER TABLE ONLY public.book
    ADD CONSTRAINT books_pkey PRIMARY KEY (id);
 9   ALTER TABLE ONLY public.book DROP CONSTRAINT books_pkey;
       public            postgres    false    216            �           2606    16925    client clients_pkey 
   CONSTRAINT     Q   ALTER TABLE ONLY public.client
    ADD CONSTRAINT clients_pkey PRIMARY KEY (id);
 =   ALTER TABLE ONLY public.client DROP CONSTRAINT clients_pkey;
       public            postgres    false    224            �           2606    16927    user employees_pkey 
   CONSTRAINT     S   ALTER TABLE ONLY public."user"
    ADD CONSTRAINT employees_pkey PRIMARY KEY (id);
 ?   ALTER TABLE ONLY public."user" DROP CONSTRAINT employees_pkey;
       public            postgres    false    226            �           2606    16929    position positions_pkey 
   CONSTRAINT     W   ALTER TABLE ONLY public."position"
    ADD CONSTRAINT positions_pkey PRIMARY KEY (id);
 C   ALTER TABLE ONLY public."position" DROP CONSTRAINT positions_pkey;
       public            postgres    false    228            �           2606    16930 #   book_issue book_issues_book_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.book_issue
    ADD CONSTRAINT book_issues_book_id_fkey FOREIGN KEY (book_id) REFERENCES public.book(id);
 M   ALTER TABLE ONLY public.book_issue DROP CONSTRAINT book_issues_book_id_fkey;
       public          postgres    false    217    216    3222            �           2606    16935 %   book_issue book_issues_client_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.book_issue
    ADD CONSTRAINT book_issues_client_id_fkey FOREIGN KEY (client_id) REFERENCES public.client(id);
 O   ALTER TABLE ONLY public.book_issue DROP CONSTRAINT book_issues_client_id_fkey;
       public          postgres    false    217    224    3230            �           2606    16940 '   book_issue book_issues_employee_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.book_issue
    ADD CONSTRAINT book_issues_employee_id_fkey FOREIGN KEY (employee_id) REFERENCES public."user"(id);
 Q   ALTER TABLE ONLY public.book_issue DROP CONSTRAINT book_issues_employee_id_fkey;
       public          postgres    false    3232    226    217            �           2606    16945 %   book_return book_returns_book_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.book_return
    ADD CONSTRAINT book_returns_book_id_fkey FOREIGN KEY (book_id) REFERENCES public.book(id);
 O   ALTER TABLE ONLY public.book_return DROP CONSTRAINT book_returns_book_id_fkey;
       public          postgres    false    216    219    3222            �           2606    16950 )   book_return book_returns_employee_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.book_return
    ADD CONSTRAINT book_returns_employee_id_fkey FOREIGN KEY (employee_id) REFERENCES public."user"(id);
 S   ALTER TABLE ONLY public.book_return DROP CONSTRAINT book_returns_employee_id_fkey;
       public          postgres    false    219    226    3232            �           2606    16955 &   book_return book_returns_state_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.book_return
    ADD CONSTRAINT book_returns_state_id_fkey FOREIGN KEY (state_id) REFERENCES public.book_state(id);
 P   ALTER TABLE ONLY public.book_return DROP CONSTRAINT book_returns_state_id_fkey;
       public          postgres    false    3228    219    221            �           2606    16960    book books_author_id_fkey    FK CONSTRAINT     {   ALTER TABLE ONLY public.book
    ADD CONSTRAINT books_author_id_fkey FOREIGN KEY (author_id) REFERENCES public.author(id);
 C   ALTER TABLE ONLY public.book DROP CONSTRAINT books_author_id_fkey;
       public          postgres    false    216    3218    214            �           2606    16965    user employees_position_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public."user"
    ADD CONSTRAINT employees_position_id_fkey FOREIGN KEY (position_id) REFERENCES public."position"(id);
 K   ALTER TABLE ONLY public."user" DROP CONSTRAINT employees_position_id_fkey;
       public          postgres    false    3234    228    226            �           2606    16970 $   book_issue fk-book_issue-employee_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.book_issue
    ADD CONSTRAINT "fk-book_issue-employee_id" FOREIGN KEY (employee_id) REFERENCES public."user"(id) ON DELETE SET NULL;
 P   ALTER TABLE ONLY public.book_issue DROP CONSTRAINT "fk-book_issue-employee_id";
       public          postgres    false    226    217    3232            �           2606    16975 &   book_return fk-book_return-employee_id    FK CONSTRAINT     �   ALTER TABLE ONLY public.book_return
    ADD CONSTRAINT "fk-book_return-employee_id" FOREIGN KEY (employee_id) REFERENCES public."user"(id) ON DELETE SET NULL;
 R   ALTER TABLE ONLY public.book_return DROP CONSTRAINT "fk-book_return-employee_id";
       public          postgres    false    226    219    3232            �           2606    16980 !   book_return fk_book_return_client    FK CONSTRAINT     �   ALTER TABLE ONLY public.book_return
    ADD CONSTRAINT fk_book_return_client FOREIGN KEY (client_id) REFERENCES public.client(id);
 K   ALTER TABLE ONLY public.book_return DROP CONSTRAINT fk_book_return_client;
       public          postgres    false    219    3230    224            <   (   x�32�0�¦�M�]l0�22B�q#q��b���� ��      >   �   x�U��iD1����zX��K6�l�*�d�nI��!8p��i�����}ݟ\x:w�T�lJ#�:�4�l���x�Ǡ6;4�e�ӧ����l6�@�����݊[t�ۺ";��dmxj����DC6��vz0�I+g��O󳭇�c%��@�{�*�������������`       ?   P   x�]���0C�s�KP�6mم�砕%m=}BcUs�I��I<��_�C�\��T8�L��@I��A�����: �k��      A   D   x�E��� ������4�
��H��g5rb�4����W谩�����Bw��a�o      C   �   x�u���@E��*��H,�b���@� �!�(�eh�#<9������+�*�-�F������21��}w��țD�'ʃ޳S��*pF�����L��Ϯ��tIRN?�g����H7��~n�~�~9Ȧ��~�      F   �   x�m�A
1E��)��mzS¨+�+�eJ=�ύLG���EB���o���"r�#FL�F������=Jk�Y��139󽭧�̲����Q�~ީ�P<�l�T�3z��Hr(���U�n:��V�����P�?�?�UޗJ�� .���      J   '   x�3��M�KLO-�2�LL����,.)J,�/����� ��	�      H   �   x�32弰�b���v\�ua߅M
&\�{�	�ܫpa΅[/l����n����ię����ǩbT�bh�Y�QZU\�i��\料�TQY��oZ����lQ�o�_��b�We�闕U^�k��ed�	�g���v]l�[AO��hC���[v��qa�%�/��T��7��M�KLO-�9�Ѥ�C�-��Ѹԥ284/"��0D/���;=��9�)���<+)�+<ܣ���Կ0��\�+F��� �It�     