SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[neuromodulation](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[submission_date] [datetime] NOT NULL,
	[first_name] [varchar](50) NOT NULL,
	[surname] [varchar](50) NOT NULL,
	[birth_date] [date] NOT NULL,
	[age] [int] NOT NULL,
	[q1] [int] NOT NULL,
	[q2] [int] NOT NULL,
	[q3] [int] NOT NULL,
	[q4] [int] NOT NULL,
	[q5] [int] NOT NULL,
	[q6] [int] NOT NULL,
	[q7] [int] NOT NULL,
	[q8] [int] NOT NULL,
	[q9] [int] NOT NULL,
	[q10] [int] NOT NULL,
	[q11] [int] NOT NULL,
	[q12] [int] NOT NULL,
	[total_score] [int] NOT NULL
) ON [PRIMARY]
GO
ALTER TABLE [dbo].[neuromodulation] ADD  CONSTRAINT [PK_neuromodulation] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, IGNORE_DUP_KEY = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
ALTER TABLE [dbo].[neuromodulation] ADD  DEFAULT (getdate()) FOR [submission_date]
GO
