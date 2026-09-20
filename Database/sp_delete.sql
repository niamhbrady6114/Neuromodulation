SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE PROC [dbo].[sp_delete_neuromodulation] (
    @id INT = NULL
)

AS 

    SET NOCOUNT ON

    BEGIN 

        DELETE FROM neuromodulation
        WHERE id = @id

    END
    SET NOCOUNT OFF

GO
