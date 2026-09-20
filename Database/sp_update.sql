SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROC [dbo].[sp_update_neuromodulation] (

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
    @id INT
)

AS 
    BEGIN
        SET NOCOUNT ON 

        UPDATE neuromodulation
        SET    
            first_name = @first_name, 
            surname = @surname, 
            birth_date = @birth_date, 
            age = @age, 
            q1 = @q1, 
            q2 = @q2, 
            q3 = @q3, 
            q4 = @q4, 
            q5 = @q5, 
            q6 = @q6,
            q7 = @q7,
            q8 = @q8,
            q9 = @q9,
            q10 = @q10,
            q11 = @q11,
            q12 = @q12,
            total_score = @total_score

        WHERE id = @id

        SET NOCOUNT OFF 
    END
GO
