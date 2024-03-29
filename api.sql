USE [master]
GO
/****** Object:  Database [api_sholat]    Script Date: 17/05/2023 11:34:21 ******/
CREATE DATABASE [api_sholat]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'api_sholat', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL16.MSSQLSERVER\MSSQL\DATA\api_sholat.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'api_sholat_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL16.MSSQLSERVER\MSSQL\DATA\api_sholat_log.ldf' , SIZE = 8192KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
 WITH CATALOG_COLLATION = DATABASE_DEFAULT, LEDGER = OFF
GO
ALTER DATABASE [api_sholat] SET COMPATIBILITY_LEVEL = 160
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [api_sholat].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [api_sholat] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [api_sholat] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [api_sholat] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [api_sholat] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [api_sholat] SET ARITHABORT OFF 
GO
ALTER DATABASE [api_sholat] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [api_sholat] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [api_sholat] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [api_sholat] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [api_sholat] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [api_sholat] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [api_sholat] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [api_sholat] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [api_sholat] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [api_sholat] SET  DISABLE_BROKER 
GO
ALTER DATABASE [api_sholat] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [api_sholat] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [api_sholat] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [api_sholat] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [api_sholat] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [api_sholat] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [api_sholat] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [api_sholat] SET RECOVERY FULL 
GO
ALTER DATABASE [api_sholat] SET  MULTI_USER 
GO
ALTER DATABASE [api_sholat] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [api_sholat] SET DB_CHAINING OFF 
GO
ALTER DATABASE [api_sholat] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [api_sholat] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [api_sholat] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [api_sholat] SET ACCELERATED_DATABASE_RECOVERY = OFF  
GO
EXEC sys.sp_db_vardecimal_storage_format N'api_sholat', N'ON'
GO
ALTER DATABASE [api_sholat] SET QUERY_STORE = ON
GO
ALTER DATABASE [api_sholat] SET QUERY_STORE (OPERATION_MODE = READ_WRITE, CLEANUP_POLICY = (STALE_QUERY_THRESHOLD_DAYS = 30), DATA_FLUSH_INTERVAL_SECONDS = 900, INTERVAL_LENGTH_MINUTES = 60, MAX_STORAGE_SIZE_MB = 1000, QUERY_CAPTURE_MODE = AUTO, SIZE_BASED_CLEANUP_MODE = AUTO, MAX_PLANS_PER_QUERY = 200, WAIT_STATS_CAPTURE_MODE = ON)
GO
USE [api_sholat]
GO
/****** Object:  User [prod]    Script Date: 17/05/2023 11:34:21 ******/
CREATE USER [prod] FOR LOGIN [prod] WITH DEFAULT_SCHEMA=[dbo]
GO
/****** Object:  Table [dbo].[jadwal_sholat]    Script Date: 17/05/2023 11:34:21 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[jadwal_sholat](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[tanggal] [varchar](50) NULL,
	[imsak] [time](2) NULL,
	[subuh] [time](2) NULL,
	[terbit] [time](2) NULL,
	[dhuha] [time](2) NULL,
	[dzuhur] [time](2) NULL,
	[ashar] [time](2) NULL,
	[maghrib] [time](2) NULL,
	[isya] [time](2) NULL,
	[date] [date] NULL,
 CONSTRAINT [PK_jadwal_sholat] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[status]    Script Date: 17/05/2023 11:34:21 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[status](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
	[deleted_at] [datetime] NULL,
	[status_mesin] [varchar](10) NULL,
 CONSTRAINT [PK_status] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
SET IDENTITY_INSERT [dbo].[jadwal_sholat] ON 

INSERT [dbo].[jadwal_sholat] ([id], [tanggal], [imsak], [subuh], [terbit], [dhuha], [dzuhur], [ashar], [maghrib], [isya], [date]) VALUES (1, N'Selasa, 16/05/2023', CAST(N'04:24:00' AS Time), CAST(N'04:34:00' AS Time), CAST(N'05:49:00' AS Time), CAST(N'06:18:00' AS Time), CAST(N'11:51:00' AS Time), CAST(N'15:12:00' AS Time), CAST(N'17:45:00' AS Time), CAST(N'18:57:00' AS Time), CAST(N'2023-05-16' AS Date))
INSERT [dbo].[jadwal_sholat] ([id], [tanggal], [imsak], [subuh], [terbit], [dhuha], [dzuhur], [ashar], [maghrib], [isya], [date]) VALUES (2, N'Rabu, 17/05/2023', CAST(N'04:24:00' AS Time), CAST(N'04:34:00' AS Time), CAST(N'05:49:00' AS Time), CAST(N'06:18:00' AS Time), CAST(N'11:51:00' AS Time), CAST(N'15:12:00' AS Time), CAST(N'17:45:00' AS Time), CAST(N'18:57:00' AS Time), CAST(N'2023-05-17' AS Date))
SET IDENTITY_INSERT [dbo].[jadwal_sholat] OFF
GO
SET IDENTITY_INSERT [dbo].[status] ON 

INSERT [dbo].[status] ([id], [created_at], [updated_at], [deleted_at], [status_mesin]) VALUES (1, CAST(N'2023-05-16T14:16:19.000' AS DateTime), CAST(N'2023-05-17T09:23:34.000' AS DateTime), NULL, N'ON')
SET IDENTITY_INSERT [dbo].[status] OFF
GO
USE [master]
GO
ALTER DATABASE [api_sholat] SET  READ_WRITE 
GO
