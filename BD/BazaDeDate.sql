CREATE TABLE dbo.Users([ID] [integer] identity(1,1) NOT NULL ,
[Nume] [varchar](255) NOT NULL , 
[Email] [varchar](255) NOT NULL, 
[Parola] [varchar](255) NOT NULL,
[Rol] [varchar](255) NOT NULL,
[Nota] [decimal](5,2) ,
[AnStudiu] [integer] ,
[Materie] [varchar](255),
[Facultate] [varchar] (255),
[Specializare] [varchar] (255)
CONSTRAINT [PK_Users] PRIMARY KEY CLUSTERED
(
[ID] ASC
)WITH (IGNORE_DUP_KEY = OFF) ON [PRIMARY]) ON [PRIMARY]
select * from Users

CREATE TABLE dbo.Facultatati([Nume] [varchar](255),
CONSTRAINT [PK_Facultati] PRIMARY KEY CLUSTERED
(
[Nume] ASC
)WITH (IGNORE_DUP_KEY = OFF) ON [PRIMARY]) ON [PRIMARY]
select * from Facultatati

CREATE TABLE dbo.Materii([MaterieID] [integer] NOT NULL,
[NumeFacultate] [varchar](255) NOT NULL,
[IDProfesor] [integer] NOT NULL,
[NumeMaterie] [varchar](255) NOT NULL,
[NrCredite] [integer] NOT NULL,
[Semestrul] [integer] NOT NULL,
[Anul] [integer] NOT NULL,
CONSTRAINT [PK_Materii] PRIMARY KEY CLUSTERED
(
[MaterieID] ASC
)WITH (IGNORE_DUP_KEY = OFF) ON [PRIMARY]) ON [PRIMARY]
select * from Materii


CREATE TABLE dbo.MaterieStudent([MaterieID] [integer] NOT NULL, 
[StudentID] [integer] NOT NULL)
select * from MaterieStudent

ALTER TABLE [dbo].[Materii] WITH CHECK ADD
CONSTRAINT [FK_Materii_NumeDepartament] FOREIGN KEY([NumeDepartament])
REFERENCES [dbo].[Departament] ([Nume])
GO
ALTER TABLE [dbo].[Materii] CHECK
CONSTRAINT [FK_Materii_NumeDepartament]
GO

ALTER TABLE [dbo].[MaterieStudent] WITH CHECK ADD
CONSTRAINT [FK_MaterieStudent_MaterieID] FOREIGN KEY([MaterieID])
REFERENCES [dbo].[Materii] ([MaterieID])
GO
ALTER TABLE [dbo].[MaterieStudent] CHECK
CONSTRAINT [FK_MaterieStudent_MaterieID]
GO

ALTER TABLE [dbo].[MaterieStudent] WITH CHECK ADD
CONSTRAINT [FK_MaterieStudent_StudentID] FOREIGN KEY([StudentID])
REFERENCES [dbo].[Users] ([ID])
GO
ALTER TABLE [dbo].[MaterieStudent] CHECK
CONSTRAINT [FK_MaterieStudent_StudentID]
GO


insert into Cat
(Nume, Parola, Nota, Materie, Credite)
values
('Adrian', 'test', '5.00', 'Math', '4.00')

insert into users
(Nume, Email, Parola, Rol, Departament, Nota, AnStudiu, Materie)
values
('Adrian', 'adr@gmail.com', 'test', 'student', 'Mate-info', null, 1, 'P3', '5.00')

select Users.Nume, Materii.NumeMaterie, Materii.NrCredite, Materii.Semestrul, Materii.Anul
from Users, Materii

select Users.Nume, Materii.NumeMaterie, Materii.Semestrul, Users.Nota
from Users, Materii

select * from users

select * from Cat


DELETE FROM Cat WHERE Credite='4.00';


ALTER TABLE Cat ADD Credite varchar(20) NULL

ALTER TABLE Cat
DROP COLUMN Credite;
