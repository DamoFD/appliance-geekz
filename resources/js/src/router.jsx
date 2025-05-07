import { createBrowserRouter } from 'react-router-dom';
import Home from './pages/Home';
import Options from './pages/Options';
import Faults from './pages/Faults';

const router = createBrowserRouter([
    {
        path: '/dashboard',
        element: <Home />,
    },
    {
        path: '/dashboard/options',
        element: <Options />,
    },
    {
        path: '/dashboard/faults',
        element: <Faults />,
    },
]);

export default router;
