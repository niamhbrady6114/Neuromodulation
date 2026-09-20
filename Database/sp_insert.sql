SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROC [dbo].[sp_insert_neuromodulation] (

    @first_name varchar(50),
    @surname varchar(50),
    @birth_date date,
    @age int,
    @q1 int,
    @q2 int,
    @q3 int,
    @q4 int,
    @q5 int,
    @q6 int,
    @q7 int,
    @q8 int,
    @q9 int,
    @q10 int,
    @q11 int,
    @q12 int,
    @total_score int,
    @output_id INT OUTPUT
)

AS 
    BEGIN
        SET NOCOUNT ON 

        INSERT INTO neuromodulation(
                first_name, 
                surname, 
                birth_date,
                age,
                q1,
                q2,
                q3,
                q4,
                q5,
                q6,
                q7,
                q8,
                q9,
                q10,
                q11,
                q12,
                total_score
            ) 
        SELECT 
            @first_name, 
            @surname, 
            @birth_date,
            @age,
            @q1,
            @q2,
            @q3,
            @q4,
            @q5,
            @q6,
            @q7,
            @q8,
            @q9,
            @q10,
            @q11,
            @q12,
            @total_score

        SET @output_id = SCOPE_IDENTITY()

        SET NOCOUNT OFF 
    END
GO
