<?php

namespace App\Types;

enum NoteType: string
{
    case GoogleDocument = 'GoogleDocument';
    case GoogleDriveFolder = 'GoogleDriveFolder';
    case GoogleSlides = 'GoogleSlides';
    case JupyterNotebook = 'JupyterNotebook';
    case Image = 'Image';
    case Video = 'Video';
    case Quizlet = 'Quizlet';
    case Notion = 'Notion';
    case Others = 'Others';
}

enum NoteYear: int
{
    case Sec1 = 1;
    case Sec2 = 2;
    case Sec3 = 3;
    case Sec4 = 4;
    case JC1 = 5;
    case JC2 = 6;
}

enum NoteStatus: int
{
    case Planned = 1;
    case Ongoing = 2;
    case Completed = 3;
}

enum NoteSubject: string
{
    case SecCID = 'SecCID';
    case SecArt = 'SecArt';
    case SecAppreciationOfChineseCulture = 'SecAppreciationOfChineseCulture';
    case SecMusic = 'SecMusic';
    case SecDigitalLiteracy = 'SecDigitalLiteracy';
    case SecConversationalMalay = 'SecConversationalMalay';
    case SecFoodAndConsumerEducation = 'SecFoodAndConsumerEducation';
    case SecPhysicalEducation = 'SecPhysicalEducation';
    case SecMathematics = 'SecMathematics';
    case SecBiology = 'SecBiology';
    case SecBiologyTalent = 'SecBiologyTalent';
    case SecChemistry = 'SecChemistry';
    case SecChemistryTalent = 'SecChemistryTalent';
    case SecPhysics = 'SecPhysics';
    case SecPhysicsTalent = 'SecPhysicsTalent';
    case SecComputing = 'SecComputing';
    case SecEnglishLanguage = 'SecEnglishLanguage';
    case SecEnglishLiterature = 'SecEnglishLiterature';
    case SecHigherChineseLanguage = 'SecHigherChineseLanguage';
    case SecChineseLiterature = 'SecChineseLiterature';
    case SecGeography = 'SecGeography';
    case SecHistory = 'SecHistory';
    case SecSingaporeStudies = 'SecSingaporeStudies';
    case SecBiculturalStudies = 'SecBiculturalStudies';
    case JCChinaStudiesInChineseH2 = 'JCChinaStudiesInChineseH2';
    case JCChineseLanguageAndLiteratureH2 = 'JCChineseLanguageAndLiteratureH2';
    case JCEnglishLiteratureH1 = 'JCEnglishLiteratureH1';
    case JCEnglishLiteratureH2 = 'JCEnglishLiteratureH2';
    case JCEconomicsH1 = 'JCEconomicsH1';
    case JCEconomicsH2 = 'JCEconomicsH2';
    case JCGeographyH2 = 'JCGeographyH2';
    case JCHistoryH2 = 'JCHistoryH2';
    case JCTranslationH2 = 'JCTranslationH2';
    case JCBiologyH2 = 'JCBiologyH2';
    case JCComputingH2 = 'JCComputingH2';
    case JCChemistryH1 = 'JCChemistryH1';
    case JCChemistryH2 = 'JCChemistryH2';
    case JCChemistryH3 = 'JCChemistryH3';
    case JCFurtherMathematicsH2 = 'JCFurtherMathematicsH2';
    case JCPhysicsH2 = 'JCPhysicsH2';
    case JCPhysicsH3 = 'JCPhysicsH3';
    case JCMathematicsH1 = 'JCMathematicsH1';
    case JCMathematicsH2 = 'JCMathematicsH2';
    case JCMathematicsH3 = 'JCMathematicsH3';
    case JCGeneralPaperH1 = 'JCGeneralPaperH1';
    case JCMotherTongueH1 = 'JCMotherTongueH1';
    case JCProjectWorkH1 = 'JCProjectWorkH1';
    case OtherSubject = 'OtherSubject';
    case NonAcademic = 'NonAcademic';
}

enum MessageThreadType: string
{
    case CollaborationRequest = 'CollaborationRequest';
    case CommentAlert = 'CommentAlert';
}