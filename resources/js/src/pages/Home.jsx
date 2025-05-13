import BlueSwirl from '/public/images/blue-swirl.png';
import Input from '../components/Input';
import { MdOutlineBrandingWatermark } from 'react-icons/md';
import { TbBoxModel2, TbHash } from 'react-icons/tb';
import { useAuth } from '../contexts/AuthContextProvider';
import { useAppliance } from '../contexts/ApplianceContextProvider';
import { useNavigate } from 'react-router-dom';

const Home = () => {
    const { user } = useAuth();
    const { appliance, setAppliance } = useAppliance();
    const navigate = useNavigate();

    return (
        <div className="min-h-screen w-full bg-dark-900 p-8 md:py-8 md:px-24 lg:py-12 lg:px-[500px]">
            <h1
                className="font-inter font-bold text-5xl primary-text-gradient"
            >
                Hello,<br />{user.name}
            </h1>
            <p
                className="text-white font-inter text-lg primary-text-gradient mt-4"
            >
                Need help with your appliance?
            </p>
            <img
              src={BlueSwirl}
              alt="blue swirl"
              className="w-full mt-4 lg:w-1/2"
            />
            <p
                className="text-white font-inter text-lg primary-text-gradient mt-4"
            >
                I'll need some information
            </p>
            <div
                className="flex flex-col w-full gap-4 mt-4"
            >
                <Input
                    placeholder="Brand"
                    EndAdornment={MdOutlineBrandingWatermark}
                    value={appliance.brand}
                    onChange={(e) => setAppliance({ ...appliance, brand: e.target.value })}
                />
                <Input
                    placeholder="Model"
                    EndAdornment={TbBoxModel2}
                    value={appliance.model}
                    onChange={(e) => setAppliance({ ...appliance, model: e.target.value })}
                />
                <Input
                    placeholder="Serial"
                    EndAdornment={TbHash}
                    value={appliance.serial}
                    onChange={(e) => setAppliance({ ...appliance, serial: e.target.value })}
                />
            </div>
            <button
                className="w-full py-2 rounded-lg mt-10 font-inter text-white primary-gradient text-xl"
                onClick={() => navigate('/app/options')}
            >
                Continue
            </button>
        </div>
    );
}

export default Home;
