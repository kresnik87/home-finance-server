<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\User;

class AdminController extends BaseAdminController
{

    public function loggedAction(Request $request)
    {
        $authChecker = $this->container->get('security.authorization_checker');
        $router = $this->container->get('router');

        if ($authChecker->isGranted(User::ROLE_ADMIN) || $authChecker->isGranted(User::ROLE_SUPER_ADMIN))
        {
            return new RedirectResponse($router->generate('admin'), 307);
        }

        if ($authChecker->isGranted(User::ROLE_USER))
        {
            return new RedirectResponse($router->generate('profile'), 307);
        }
        return new RedirectResponse($router->generate('login'), 307);
    }

    /**
     * @Route("/api-dashboard", name="api")
     */
    public function apiDashboardAction()
    {

        return $this->render(
                        '@Templates/easy_admin/api_dashboard.html.twig', [
                    'api_doc_url' => '/api',
                        ]
        );
    }

}
