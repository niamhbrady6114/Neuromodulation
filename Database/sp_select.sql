SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROC [dbo].[sp_select_neuromodulation] (
    @id INT = NULL
)

AS 

    SET NOCOUNT ON

    BEGIN 

        SELECT * FROM neuromodulation 
        WHERE id = COALESCE(@id, id)

    END
    SET NOCOUNT OFF
GO
