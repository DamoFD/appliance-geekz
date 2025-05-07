import { createBrowserRouter } from 'react-router-dom';
import Home from './pages/Home';
import Options from './pages/Options';

const router = createBrowserRouter([
    {
        path: '/dashboard',
        element: <Home />,
    },
    {
        path: '/dashboard/options',
        element: <Options />,
    },
]);

export default router;
