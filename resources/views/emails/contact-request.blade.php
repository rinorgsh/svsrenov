<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle demande de contact</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f4f4f4;">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table role="presentation" style="width: 600px; border-collapse: collapse; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #C8102E 0%, #8B0000 100%); padding: 30px 40px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: bold;">
                                SVS RENOV
                            </h1>
                            <p style="color: #ffffff; margin: 10px 0 0 0; font-size: 14px; opacity: 0.9;">
                                Nouvelle demande de devis
                            </p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px;">
                            <!-- Alert Badge -->
                            <table role="presentation" style="width: 100%; margin-bottom: 30px;">
                                <tr>
                                    <td style="background-color: #FEF3C7; border-left: 4px solid #F59E0B; padding: 15px 20px; border-radius: 4px;">
                                        <p style="margin: 0; color: #92400E; font-size: 14px;">
                                            <strong>Nouvelle demande reçue le {{ $contactRequest->created_at->format('d/m/Y à H:i') }}</strong>
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Client Info -->
                            <h2 style="color: #1F2937; font-size: 18px; margin: 0 0 20px 0; padding-bottom: 10px; border-bottom: 2px solid #E5E7EB;">
                                Informations du client
                            </h2>

                            <table role="presentation" style="width: 100%; margin-bottom: 30px;">
                                <tr>
                                    <td style="padding: 10px 0; border-bottom: 1px solid #F3F4F6;">
                                        <strong style="color: #6B7280; font-size: 14px;">Nom :</strong>
                                    </td>
                                    <td style="padding: 10px 0; border-bottom: 1px solid #F3F4F6; text-align: right;">
                                        <span style="color: #1F2937; font-size: 14px;">{{ $contactRequest->name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; border-bottom: 1px solid #F3F4F6;">
                                        <strong style="color: #6B7280; font-size: 14px;">Email :</strong>
                                    </td>
                                    <td style="padding: 10px 0; border-bottom: 1px solid #F3F4F6; text-align: right;">
                                        <a href="mailto:{{ $contactRequest->email }}" style="color: #C8102E; text-decoration: none; font-size: 14px;">{{ $contactRequest->email }}</a>
                                    </td>
                                </tr>
                                @if($contactRequest->phone)
                                <tr>
                                    <td style="padding: 10px 0; border-bottom: 1px solid #F3F4F6;">
                                        <strong style="color: #6B7280; font-size: 14px;">Téléphone :</strong>
                                    </td>
                                    <td style="padding: 10px 0; border-bottom: 1px solid #F3F4F6; text-align: right;">
                                        <a href="tel:{{ $contactRequest->phone }}" style="color: #C8102E; text-decoration: none; font-size: 14px;">{{ $contactRequest->phone }}</a>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="padding: 10px 0;">
                                        <strong style="color: #6B7280; font-size: 14px;">Service demandé :</strong>
                                    </td>
                                    <td style="padding: 10px 0; text-align: right;">
                                        <span style="background-color: #C8102E; color: #ffffff; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                                            {{ $contactRequest->service?->title_fr ?? 'Non spécifié' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            <!-- Message -->
                            <h2 style="color: #1F2937; font-size: 18px; margin: 0 0 20px 0; padding-bottom: 10px; border-bottom: 2px solid #E5E7EB;">
                                Message
                            </h2>

                            <div style="background-color: #F9FAFB; padding: 20px; border-radius: 8px; border: 1px solid #E5E7EB;">
                                <p style="margin: 0; color: #374151; font-size: 14px; line-height: 1.6; white-space: pre-wrap;">{{ $contactRequest->message }}</p>
                            </div>

                            <!-- CTA Button -->
                            <table role="presentation" style="width: 100%; margin-top: 30px;">
                                <tr>
                                    <td align="center">
                                        <a href="mailto:{{ $contactRequest->email }}?subject=Re: Votre demande de devis - SVS RENOV"
                                           style="display: inline-block; background-color: #C8102E; color: #ffffff; padding: 14px 30px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 14px;">
                                            Répondre au client
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #1F2937; padding: 25px 40px; text-align: center;">
                            <p style="margin: 0; color: #9CA3AF; font-size: 12px;">
                                Cet email a été envoyé automatiquement depuis le site web SVS RENOV
                            </p>
                            <p style="margin: 10px 0 0 0; color: #9CA3AF; font-size: 12px;">
                                © {{ date('Y') }} SVS RENOV - Tous droits réservés
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
